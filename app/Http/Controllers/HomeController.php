<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function index(Request $r) {
        return view('dashboard');
    }
}
