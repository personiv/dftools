<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    function index(Request $r) {
        if ($r->session()->get("user") != null) {
            return view('dashboard');
        } else {
            return back()->with("msg", "Please login again to continue");
        }
    }
}
