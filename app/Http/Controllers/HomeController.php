<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {
    function session(Request $r) {
        return view('session');
    }
}
