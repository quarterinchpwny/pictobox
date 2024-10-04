<?php

namespace App\Http\Traits;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

trait HttpJsonResponse
{

    /**
     * Returns a successful JSON response with the given data, message, and code.
     * The default code is 200 (OK).
     *
     * @param mixed $data The data to be returned in the response.
     * @param string|null $message The message to be returned in the response.
     * @param int $code The HTTP code to be returned in the response.
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($data, $message = null, $code = Response::HTTP_OK)
    {
        return response()->json([
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * @param \Throwable $e
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($e, $message = 'Something went wrong', $code = Response::HTTP_BAD_REQUEST)
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
