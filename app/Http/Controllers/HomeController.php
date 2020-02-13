<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;
use App\ScoreItem;
use App\Session;

class HomeController extends Controller {
    function session($sid) {
        $session = Session::where("session_id", $sid)->first();
        if ($session == null) return redirect()->route("dashboard")->with(["msg" => "Session with ID '$sid' does not exists"]);
        return view('session')->with(["session" => $session]);
    }

    function createSession(Request $r) {
        $date = explode("/", date("M/d/Y/W"));

        // Save to database as AGENT level pending session
        $session = new Session;
        $session->setAttribute("session_type", $r->input("session-type"));
        $session->setAttribute("session_agent", $r->input("session-agent"));
        $session->setAttribute("session_mode", $r->input("session-mode") != "" ? "manual" : "actual");
        $session->setAttribute("session_year", $date[2]);
        $session->setAttribute("session_month", strtoupper($date[0]));
        $session->setAttribute("session_day", $date[1]);
        $session->setAttribute("session_week", $date[3]);
        $session->setAttribute("session_compatible_data", $session->Data());
        $session->save();
        
        // Display the same session as it is already exists this week
        if ($session->ExistsThisWeek()) return redirect()->route('session', [$session->ExistingSession()->SessionID()]);
        return redirect()->route('session', [$session->SessionID()]);
    }
}
