<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credential;
use App\ScoreItem;
use App\Session;
use App\Exception;

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
        $session->setAttribute("session_data", $session->GenerateData());
        
        if ($session->ExistsThisWeek()) {
            // Display the same session as it is already exists this week
            return redirect()->route('session', [$session->ExistingSession()->SessionID()]);
        } else {
            $session->save();
            return redirect()->route('session', [$session->SessionID()]);
        }
    }

    function movePendingLevel(Request $r) {
        $session = Session::where("session_id", $r->input("session-id"))->first();
        $session->MovePendingLevel($r);
        return redirect()->route('dashboard');
    }

    function addException(Request $r) {
        $agentID = $r->input("exception-agent");
        $reason = $r->input("exception-reason");
        if (Exception::where("exception_agent", $agentID)->count() > 0) return redirect()->route('dashboard');
        
        $exception = new Exception;
        $exception->setAttribute("exception_agent", $agentID);
        $exception->setAttribute("exception_reason", $reason);
        $exception->setAttribute("exception_week", date("W"));
        $exception->save();
        return redirect()->route('dashboard');
    }
}
