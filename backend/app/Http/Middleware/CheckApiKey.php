<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        // Check api key
        $apiKey = $request->bearerToken();
        if ($apiKey !== env('API_KEY')) {
            return response()->json([
                'error' => 'Unauthorized',
                'errorEx' => 'Invalid API key'
            ], 401);
        }
        return $next($request);
    }
}