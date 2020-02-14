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
        $user = $request->session()->get("user");
        if ($user != null)
            if ($user->EmployeeID() != "admin") {
                if ($user->AccountType() != "ADMIN")
                    return $next($request);
            } else {
                return redirect()->route("admin");
            }

        return redirect()->route("index")->with(["msg" => "Please login again to continue"]);
    }
}
