<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;

class LoginController extends Controller {
    function index(Request $r) {
        $user = $r->session()->get("user");
        if ($user != null)
            if ($user->EmployeeID() != "admin") {
                if ($user->AccountType() != "ADMIN")
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
            $user = $account->EmployeeID();
            if ($account->Password() != $userPass) {
                return redirect()->route("index")->with(["msg" => "Incorrect username or password"]);
            }
            $r->session()->put("user", $account);
            if (!$account->IsAdmin()) return redirect()->route("dashboard");
            else return redirect()->route("admin");
        } else {
            return redirect()->route("index")->with(["msg" => "Incorrect username or password"]);
        }
    }

    function logout(Request $r) {
        $r->session()->forget("user");
        $r->session()->forget("historySessions");
        return redirect()->route("index");
    }
}
