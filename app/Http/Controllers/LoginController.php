<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;

class LoginController extends Controller {
    function index(Request $r) {
        if ($r->session()->get("user") != null)
            if ($r->session()->get("user") != "admin") {
                if ($r->session()->get("user-type") != null)
                    if ($r->session()->get("user-type") != "ADMIN")
                        return redirect()->route("dashboard");
            } else {
                return redirect()->route("admin");
            }
        
        return view('index');
    }

    function login(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        if (Credential::where("credential_user", $userId)->count() > 0) {
            $account = Credential::where("credential_user", $userId)->first();
            $user = $account->getAttribute("credential_user");
            if ($account->getAttribute("credential_pass") != $userPass) {
                return redirect()->route("index")->with(["msg" => "Incorrect username or password"]);
            }
            $r->session()->put("user", $user);
            $r->session()->put("user-type", $account->getAttribute("credential_type"));
            $r->session()->put("user-fullname", $account->getAttribute("credential_first") . ' ' . $account->getAttribute("credential_last"));
            $r->session()->put("user-role", $account->JobPosition());
            $r->session()->put("user-team", Credential::where("credential_up", $user)->get() ?? []);
            if ($account->getAttribute("credential_type") != "ADMIN") return redirect()->route("dashboard");
            else return redirect()->route("admin");
        } else {
            return redirect()->route("index")->with(["msg" => "Incorrect username or password"]);
        }
    }

    function logout(Request $r) {
        $r->session()->forget("user");
        $r->session()->forget("user-type");
        $r->session()->forget("user-fullname");
        $r->session()->forget("user-role");
        $r->session()->forget("user-team");
        return redirect()->route("index");
    }
}
