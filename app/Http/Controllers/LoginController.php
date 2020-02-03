<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;

class LoginController extends Controller {
    function index(Request $r) {
        $r->session()->forget("user");
        return view('index');
    }

    function login(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        if (Credential::where("credential_user", $userId)->count() > 0) {
            $account = Credential::where("credential_user", $userId)->first();
            $user = $account->getAttribute("credential_user");
            if ($account->getAttribute("credential_pass") != $userPass) {
                return back()->with("msg", "Incorrect username or password");
            }
            $r->session()->put("user", $user);
            return redirect()->route("home");
        } else {
            return back()->with("msg", "Incorrect username or password");
        }
    }
}
