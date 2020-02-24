<?php

namespace App\Http\Middleware;

use Closure;
use App\Poll;

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
        $user = $request->session()->get("user");
        if ($user != null) {
            if ($user->EmployeeID() == "admin") {
                if ($user->AccountType() == "ADMIN")
                    return $next($request);
            } else {
                Poll::Queue("System", $user->EmployeeID(), "Access denied");
                redirect()->route("dashboard");
            }
        }
        return redirect()->route("index")->with(["msg" => "Access denied"]);
    }
}
