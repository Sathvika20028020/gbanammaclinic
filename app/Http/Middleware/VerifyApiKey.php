<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $expectedKey = config('services.whatsapp.api_key');

        if (!$expectedKey) {
            Log::critical('WHATSAPP_API_KEY missing from config');
            return response()->json([
                'message' => 'Server error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $incomingKey =
            $request->header('X-API-KEY') ??
            $request->bearerToken() ??
            $request->query('api_key'); // MVP fallback only

        if (!$incomingKey || !hash_equals($expectedKey, $incomingKey)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
