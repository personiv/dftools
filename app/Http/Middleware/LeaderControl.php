<?php

namespace App\Http\Middleware;

use Closure;
use App\Poll;

class LeaderControl
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
            if ($user->AccountType() == "SPRVR" || $user->AccountType() == "MANGR" || $user->AccountType() == "HEAD") {
                return $next($request);
            } else {
                Poll::Queue("System", $user->EmployeeID(), "Access denied");
                redirect()->route("dashboard");
            }
        }
        return redirect()->route("index")->with(["msg" => "Access denied"]);
    }
}
