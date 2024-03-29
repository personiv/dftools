<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Credential;
use App\ScoreItem;
use App\Session;
use App\Exception;
use App\Feedback;
use App\Poll;

class HomeController extends Controller {
    function queuePoll(Request $r) {
        $data = json_decode($r->getContent(), true);
        Poll::Queue($data["sender"], $data["receiver"], $data["message"]);
    }

    function getPolls(Request $r) {
        $data = json_decode($r->getContent(), true);
        $polls = array();
        $pollAvailable = Poll::Get($data["receiver"]);
        foreach ($pollAvailable as $poll) {
            array_push($polls, [
                "poll_id" => $poll->getAttribute("poll_id"),
                "poll_time" => strtotime($poll->getAttribute("created_at")) * 1000,
                "poll_sender" => $poll->Sender(),
                "poll_message" => $poll->Message()
            ]);
        }
        return $polls;
    }

    function dequeuePoll(Request $r) {
        $data = json_decode($r->getContent(), true);
        Poll::destroy($data["id"]);
    }

    function session($sid) {
        $session = Session::where("session_id", $sid)->first();
        if ($session == null) return redirect()->route("dashboard");
        return view('session')->with(["session" => $session]);
    }

    function print($sid) {
        $session = Session::where("session_id", $sid)->first();
        if ($session == null) return redirect()->route("dashboard");
        return view('print')->with(["session" => $session]);
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
            Poll::Queue("System", $r->session()->get("user")->EmployeeID(), "Session already exists this week, viewing the same session");
            return redirect()->route('session', [$session->ExistingSession()->SessionID()]);
        } else {
            $session->save();
            Poll::Queue($r->session()->get("user")->FullName(), $r->input("session-agent"), "You have new pending session to be completed");
            return redirect()->route('session', [$session->SessionID()]);
        }
    }

    function movePendingLevel(Request $r) {
        $session = Session::where("session_id", $r->input("session-id"))->first();
        if (!$session->MovePendingLevel($r)) {
            // Notify the signee about the error
            Poll::Queue("System", $r->session()->get("user")->EmployeeID(), "Failed to verify when signing the pending session");
            return redirect()->route('session', [$r->input("session-id")])->withInput();
        } else {
            // Notify the next signee
            foreach ($session->Signees() as $signeeID => $signed) {
                if ($session->IsNextSignee($signeeID)) {
                    Poll::Queue("System", $signeeID, $r->session()->get("user")->FullName() . " signed his/her pending session");
                    break;
                }
            }
            return redirect()->route('dashboard');
        }
    }
    
    function resetPending(Request $r) {
        $session = Session::where("session_id", $r->input("session-id"))->first();
        $session->ResetPending($r);
        return redirect()->route('dashboard');
    }

    function updateFieldValue(Request $r) {
        $data = json_decode($r->getContent(), true);
        $session = Session::where("session_id", $data["sessionID"])->first();
        $session->updateField($r, $data);
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

    function editException(Request $r) {
        $exceptionId = $r->input("edit-exception-id");
        $agentID = $r->input("edit-exception-agent");
        $reason = $r->input("edit-exception-reason");
        $exception = Exception::where("exception_id", $exceptionId)->first();
        if ($exception == null || $exception->AgentLeader()->EmployeeID() != $r->session()->get("user")->EmployeeID())
            return redirect()->route('dashboard');

        $exception->setAttribute("exception_agent", $agentID);
        $exception->setAttribute("exception_reason", $reason);
        $exception->save();
        return redirect()->route('dashboard');
    }

    function deleteException($eid, Request $r) {
        $exception = Exception::where("exception_id", $eid)->first();
        if ($exception == null || $exception->AgentLeader()->EmployeeID() != $r->session()->get("user")->EmployeeID())
            return redirect()->route('dashboard');
        
        $exception->delete();
        return redirect()->route('dashboard');
    }

    function addFeedback(Request $r) {
        $sender = $r->input("feedback-sender") != "" ? $r->input("feedback-sender") : "Anonymous";
        $comment = $r->input("feedback-comment");
        
        $feedback = new Feedback;
        $feedback->setAttribute("feedback_sender", $sender);
        $feedback->setAttribute("feedback_comment", $comment);
        $feedback->save();
        return redirect()->route('dashboard');
    }

    function viewHistorySessions(Request $r) {
        $sessions = $r->session()->get("user")->HistorySessions($r->input("history-start"), $r->input("history-end"));
        $r->session()->put("historySessions", $sessions);
        return redirect()->route("history");
    }

    function changePassword(Request $r) {
        $validator = Validator::make($r->all(), [ 'new-pass' => 'required|regex:/^[a-zA-Z0-9]\w{5,23}$/' ]);

        if (!$validator->fails()) {
            $user = $r->session()->get("user");
            $newPass = $r->input("new-pass");
            $user->setAttribute("credential_pass", $newPass);
            $user->save();
            Poll::Queue("System", $user->EmployeeID(), "Password successfully changed");
        } else {
            Poll::Queue("System", $user->EmployeeID(), "Failed to change the password");
        }
        return redirect()->route("dashboard");
    }

    function changePhoto(Request $r) {
        request()->validate(['new-img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:16384']);

        $user = $r->session()->get("user");
        $userImgInput = $r->file("new-img");
        if ($userImgInput == null) return redirect()->route("dashboard");
        $userImgExt = $userImgInput->getClientOriginalExtension();
        $userImg = $userImgInput->storeAs("images/profiles", $user->EmployeeID() . '.' . $userImgExt);
        $user->setAttribute("credential_img", $userImg);
        $user->save();
        Poll::Queue("System", $user->EmployeeID(), "Photo successfully changed");
        return redirect()->route("dashboard");
    }
}
