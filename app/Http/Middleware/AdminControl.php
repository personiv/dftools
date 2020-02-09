<?php

namespace App\Http\Middleware;

use Closure;

class AdminControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if ($request->session()->get("user") != null)
            if ($request->session()->get("user") == "admin") {
                if ($request->session()->get("user-type") == "ADMIN")
                    return $next($request);
            } else {
                redirect()->route("dashboard");
            }
        return redirect()->route("index")->with(["msg" => "Access denied"]);
    }
}
