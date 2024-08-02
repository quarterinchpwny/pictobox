<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

trait HttpJsonResponse
{
    public function successResponse($data, $message = null, $code = Response::HTTP_OK)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }
    public function errorResponse($e, $message = 'An error occurred', $code = Response::HTTP_BAD_REQUEST)
    {
        // Log the full error details for developers
        Log::error('Error occurred', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'code' => $code,
        ]);

        // Return a generic error message to the user
        return response()->json([
            'code' => $code,
            'message' => $message,
        ], $code);
    }
}
