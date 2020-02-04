<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;

class AdminController extends Controller {
    function index(Request $r) {
        return view('admin.addcredential');
    }

    function addCredential(Request $r) {
        return view('admin.addcredential');
    }

    function updateCredential(Request $r) {
        return view('admin.updatecredential');
    }

    function deleteCredential(Request $r) {
        return view('admin.deletecredential');
    }

    function submitAddCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        $userType = $r->input("user-type");
        if (Credential::where("credential_user", $userId)->count() < 1) {
            $account = new Credential;
            $account->setAttribute("credential_user", $userId);
            $account->setAttribute("credential_pass", $userPass);
            $account->setAttribute("credential_type", $userType);
            $account->save();
            return back()->with(["msg" => "Credential created", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential already exists");
        }
    }

    function submitUpdateCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        $userType = $r->input("user-type");

        $selected = Credential::where('credential_user', $userId)->first();
        if ($selected != null) {
            if ($userPass != "") $selected->setAttribute("credential_pass", $userPass);
            $selected->setAttribute("credential_type", $userType);
            $selected->save();
            return back()->with(["msg" => "Credential updated", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential not registered");
        }
    }

    function submitDeleteCredential(Request $r) {
        $userId = $r->input("user-id");

        $selected = Credential::where('credential_user', $userId)->first();
        if ($selected != null) {
            $selected->delete();
            return back()->with(["msg" => "Credential deleted", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential not registered");
        }
    }
}
