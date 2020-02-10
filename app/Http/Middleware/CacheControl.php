<?php

namespace App\Http\Middleware;

use Closure;

class CacheControl {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $response = $next($request);
        $response->header('Cache-Control', 'private, max-age=0, no-cache, must-revalidate, no-store');
        return $response;
    }
}
