<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Get the API key from the .env file
        $apiKey = env('API_KEY');

        // Check if the 'api_key' exists in the request headers and matches the .env key
        if ($request->header('api_key') !== $apiKey) {
            // Return a 403 Forbidden response if the API key does not match
            return response()->json([
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        // If the API key matches, proceed with the request
        return $next($request);
    }
}
