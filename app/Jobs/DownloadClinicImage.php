<?php

namespace App\Jobs;

use App\Models\ClinicSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class DownloadClinicImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Retry strategy
     */
    public int $tries = 3;
    public array $backoff = [10, 30, 60];
    public int $timeout = 20;

    public function __construct(
        public int $submissionId,
        public string $imageUrl
    ) {}

    public function handle(): void
    {
        $submission = ClinicSubmission::find($this->submissionId);

        if (!$submission) {
            return; // Record deleted, nothing to do
        }

        // Prevent double execution
        if ($submission->image_status === 'done') {
            return;
        }

        $submission->update([
            'image_status' => 'processing',
            'image_error'  => null,
        ]);

        try {
            // Security: HTTPS only
            if (!Str::startsWith($this->imageUrl, 'https://')) {
                throw new \RuntimeException('Only HTTPS image URLs allowed');
            }

            $ext = strtolower(
                pathinfo(parse_url($this->imageUrl, PHP_URL_PATH), PATHINFO_EXTENSION)
            );

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                throw new \RuntimeException('Invalid image extension');
            }

            $response = Http::timeout(10)
                ->accept('image/*')
                ->get($this->imageUrl);

            if (!$response->successful()) {
                throw new \RuntimeException('Image download failed');
            }

            // Max size: 2MB
            if (strlen($response->body()) > 2 * 1024 * 1024) {
                throw new \RuntimeException('Image exceeds size limit');
            }

            $filename = sprintf(
                'clinic_%d_%s.%s',
                $submission->id,
                Str::random(12),
                $ext
            );

            Storage::disk('public')->put(
                "clinic_submissions/{$filename}",
                $response->body()
            );

            $submission->update([
                'image_path'   => "/storage/clinic_submissions/{$filename}",
                'image_status' => 'done',
            ]);

        } catch (Throwable $e) {
            Log::warning('Clinic image download failed', [
                'submission_id' => $submission->id,
                'error' => $e->getMessage(),
            ]);

            $submission->update([
                'image_status' => 'failed',
                'image_error'  => $e->getMessage(),
            ]);

            // Allow retry
            throw $e;
        }
    }
}
