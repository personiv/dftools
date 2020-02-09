<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScoreItem;

class HomeController extends Controller {
    function session(Request $r) {
        $role = "DESGN";
        $type = "SCORE";
        $mode = "manual";
        return view('session')->with([
            "role" => $role,
            "type" => $type,
            "mode" => $mode,
            "week" => date("W"),
            "scoreitems" => ScoreItem::where("score_item_role", $role)->get()
        ]);
    }
}
