<?php
use App\Http\Controllers\Api\ClinicSubmissionController;

Route::post('/clinic-submissions', [ClinicSubmissionController::class, 'store'])
    ->middleware([
        'verify.apikey',
        'throttle:20,1',
    ]);
