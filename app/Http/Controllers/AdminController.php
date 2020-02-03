<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;

class AdminController extends Controller {
    function index(Request $r) {
        return view('admin');
    }

    function addCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        if (Credential::where("credential_user", $userId)->count() < 1) {
            $account = new Credential;
            $account->setAttribute("credential_user", $userId);
            $account->setAttribute("credential_pass", $userPass);
            $account->save();
            return back()->with(["msg" => "Credential created", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential already exists");
        }
    }
}
