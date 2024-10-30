<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class FormatResponse
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
        $next($request);
    }
}