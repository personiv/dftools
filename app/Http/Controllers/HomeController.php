<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScoreItem;

class HomeController extends Controller {
    function session(Request $r) {
        $scoreitems = ScoreItem::where("score_item_role", "DESGN")->get();
        return view('session')->with([
            "role" => "DESGN",
            "type" => "SCORE",
            "mode" => "manual",
            "week" => date("W"),
            "scoreitems" => $scoreitems
        ]);
    }
}
