<?php

namespace App\Http\Middleware;

use Closure;

class SupervisorControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = $request->session()->get("user");
        if ($user != null)
            if ($user->AccountType() == "SPRVR") {
                return $next($request);
            } else {
                redirect()->route("dashboard");
            }
        return redirect()->route("index")->with(["msg" => "Access denied"]);
    }
}
