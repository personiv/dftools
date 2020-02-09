<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;

use Closure;

class GrantControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->session()->get("user") != null) return $next($request);
        return redirect()->route("index")->with(["msg" => "Please login again to continue"]);
    }
}
