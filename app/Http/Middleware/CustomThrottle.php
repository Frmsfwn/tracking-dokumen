<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\RateLimiter;

class CustomThrottle
{
    public function handle($request, Closure $next, $guard = null)
    {
        $key = $this->resolveKey($request);

        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json(['message' => 'Too many attempts. Please try again later.'], 429);
        }

        RateLimiter::hit($key);

        $response = $next($request);

        return $response;
    }

    protected function resolveKey($request)
    {
        return 'login:' . $request->input('username');
    }
}
