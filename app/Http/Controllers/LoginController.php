<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller {
    function index(Request $r) {
        return view('index');
    }

    function login(Request $r) {
        return "Hello World!";
    }
}
