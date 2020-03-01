<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Exception;

class Credential extends Model
{
    protected $primaryKey = 'credential_id';
    static function GetCredential($employeeID) { return self::where("credential_user", $employeeID)->first(); }
    static function GetAllLeaders() {
        $types = Tag::LeaderTypes();
        for ($i = 0; $i < $types->count(); $i++) { 
            if ($i == 0) {
                $leaders = self::where("credential_type", $types[$i]->Name());
            } else {
                $leaders = $leaders->orWhere("credential_type", $types[$i]->Name());
            }
        }
        return $leaders->get();
    }

    function EmployeeID() { return $this->getAttribute("credential_user"); }
    function Password() { return $this->getAttribute("credential_pass"); }
    function AccountType() { return $this->getAttribute("credential_type"); }
    function FirstName() { return $this->getAttribute("credential_first"); }
    function LastName() { return $this->getAttribute("credential_last"); }
    function FullName() { return $this->getAttribute("credential_first") . ' ' . $this->getAttribute("credential_last"); }
    function TeamMembers() { return self::where("credential_up", $this->getAttribute("credential_user"))->get(); }
    function TeamLeader() { return self::where("credential_user", $this->getAttribute("credential_up"))->first(); }
    function Parent() { return self::where("credential_user", $this->getAttribute("credential_up"))->first(); }
    function Status() { return $this->getAttribute('credential_status') != null ? $this->getAttribute('credential_status') : "N/A"; }
    function ImagePath() { return asset($this->getAttribute("credential_img")); }
    function IsAdmin() { return $this->getAttribute("credential_type") == "ADMIN"; }
    function IsLeader() { return $this->TeamMembers()->count() > 0; }

    function JobPosition() {
        $employeeTypes = Tag::EmployeeTypes();
        for ($i = 0; $i < $employeeTypes->count(); $i++) { 
            if ($this->getAttribute("credential_type") == $employeeTypes[$i]->Name())
                return $employeeTypes[$i]->Description();
        }
        return "N/A";
    }

    function ProficiencyDetail() {
        if ($this->getAttribute("credential_hire_date") == null) return "N/A";
        $hireDate = date_create($this->getAttribute("credential_hire_date"));
        $dateNow = date_create(date("Y-m-d"));
        $dateDifference = date_diff($hireDate, $dateNow, true);
        $months = ((int)$dateDifference->format("%y") * 12) + (int)$dateDifference->format("%m");
        if ($months < 3) {
            return "Beginner (< 3 mos)";
        } else if ($months >= 3 && $months < 6) {
            return "Intermediate (> 3 mos)";
        } else {
            return "Experienced (> 6 mos)";
        }
    }

    // Agent Methods
    function ScorecardSummary() {
        return [ "agent" => self::GetCredential($this->EmployeeID()), "data" => Session::GetRowData(date("Y"), date("M"), $this->EmployeeID(), 'C', "RESOURCES") ];
    }

    function MySessionsThisWeek() {
        $sessions = array("Pending" => [], "Completed" => []);
        $myWeekSessions = array();
        $weeksessions = Session::where("session_week", (int)date("W"))->get();
        for ($i=0; $i < count($weeksessions); $i++) { 
            if ($weeksessions[$i]->Agent()->EmployeeID() == $this->EmployeeID()) {
                array_push($myWeekSessions, $weeksessions[$i]);
            }
        }

        // Iterate my sessions this week and segregate it
        foreach ($myWeekSessions as $session) {
            if ($this->EmployeeID() == $session->AgentID()) {
                if ($session->IsSignee($this->EmployeeID()) && !$session->IsSigned($this->EmployeeID())) {
                    array_push($sessions["Pending"], [
                        "sessionDate" => $session->DateCreated(),
                        "sessionType" => $session->TypeDescription(),
                        "sentBy" => $this->TeamLeader()->FullName(),
                        "sessionID" => $session->SessionID()
                    ]);
                } else if ($session->IsSignee($this->EmployeeID()) && $session->IsSigned($this->EmployeeID())) {
                    array_push($sessions["Completed"], [
                        "sessionDate" => $session->DateCreated(),
                        "sessionType" => $session->TypeDescription(),
                        "sentBy" => $this->TeamLeader()->FullName()
                    ]);
                }
            }
        }

        return $sessions;
    }

    // Team Leader Methods
    function BuildOrWhereOfChildren($current, $query, $agentIDColumnName) {
        // Recusively add 'Or Where' clause to database query to match all children (up to root children) of his credential
        if ($current == null) return;
        foreach ($current->TeamMembers() as $teamMember) {
            $query->orWhere($agentIDColumnName, $teamMember->EmployeeID());
            $this->BuildOrWhereOfChildren($teamMember, $query, $agentIDColumnName);
        }
    }

    function HistorySessions($start, $end) {
        $sessions = array();
        $historysessions = Session::whereBetween("created_at", [Carbon::parse($start)->startOfDay()->toDateTimeString(), Carbon::parse($end)->endOfDay()->toDateTimeString()])->get();
        for ($i=0; $i < count($historysessions); $i++) {
            if ($historysessions[$i]->isSignee($this->EmployeeID())) {
                array_push($sessions, $historysessions[$i]);
            }
        }
        return $sessions;
    }

    function SessionsThisWeek($leader = null) {
        $leader = $leader ?? $this->EmployeeID();
        $sessions = array();
        $weeksessions = Session::where("session_week", (int)date("W"))->get();
        for ($i=0; $i < count($weeksessions); $i++) { 
            // Check first if the user is a signee and the agent is not in the list of exception
            if ($weeksessions[$i]->IsSignee($this->EmployeeID())) {
                if ($weeksessions[$i]->IsSignee($leader) && !Exception::IsExceptedThisWeek($weeksessions[$i]->AgentID())) {
                    array_push($sessions, $weeksessions[$i]);
                }
            }
        }
        return $sessions;
    }

    function CoachingSummaryThisWeek() {
        $sessions = array("For Coaching" => [], "Pending" => [], "Completed" => []);
        $teamMembers = $this->TeamMembers();
        $weekSessions = $this->SessionsThisWeek();
        
        // For Coaching iteration
        foreach ($teamMembers as $agent) {
            // Check first if this agent is excepted
            if (Exception::IsExceptedThisWeek($agent->EmployeeID())) continue;

            // Check if this agent has session this week
            $hasSession = false;
            foreach ($weekSessions as $weekSession) {
                if ($agent->EmployeeID() == $weekSession->AgentID()) {
                    $hasSession = true;
                    break;
                }
            }

            // Only tag as [For Coaching] if this agent has no session this week
            if (!$hasSession) {
                array_push($sessions["For Coaching"], [
                    "employeeID" => $agent->EmployeeID(),
                    "fullName" => $agent->FullName(),
                    "jobPosition" => $agent->JobPosition()
                ]);
            }
        }

        // Pending and Completed iteration
        foreach ($teamMembers as $agent) {
            // Iterate sessions this week and segregate it
            foreach ($weekSessions as $weekSession) {
                if ($agent->EmployeeID() == $weekSession->AgentID()) {
                    if ($weekSession->IsSignee($this->EmployeeID()) && !$weekSession->IsSigned($this->EmployeeID())) {
                        array_push($sessions["Pending"], [
                            "sessionType" => $weekSession->TypeDescription(),
                            "employeeID" => $agent->EmployeeID(),
                            "fullName" => $agent->FullName(),
                            "jobPosition" => $agent->JobPosition(),
                            "sessionID" => $weekSession->SessionID()
                        ]);
                    } else if ($weekSession->IsSignee($this->EmployeeID()) && $weekSession->IsSigned($this->EmployeeID())) {
                        array_push($sessions["Completed"], [
                            "sessionType" => $weekSession->TypeDescription(),
                            "employeeID" => $agent->EmployeeID(),
                            "fullName" => $agent->FullName(),
                            "jobPosition" => $agent->JobPosition()
                        ]);
                    }
                }
            }
        }
        return $sessions;
    }

    function TotalOfCoachingSummaryThisWeek() {
        $count = 0;
        $coachingSummary = $this->CoachingSummaryThisWeek();
        foreach ($coachingSummary as $summaryStatus => $summaryItems) {
            $count += count($summaryItems);
        }
        return $count;
    }

    function ExceptionsThisWeek() {
        $query = Exception::where("exception_week", (int)date("W"))
            ->where(function($query) { $this->BuildOrWhereOfChildren($this, $query, "exception_agent"); });
        return $query->get();
    }

    function TeamStackRank() {
        $data = array();
        $teamMembers = $this->TeamMembers();

        foreach ($teamMembers as $teamMember) {
            $actualData = Session::GetRowData(date("Y"), date("M"), $teamMember->EmployeeID(), 'C', "RESOURCES");
            array_push($data, [ "agent" => self::GetCredential($teamMember->EmployeeID()), "data" => $actualData ]);
        }
        if (count($data) > 0) {
            usort($data, function($a, $b) {
                if (count($a["data"]) < 1) return 0;
                return $a["data"][Session::IndexOfCell("AG")] < $b["data"][Session::IndexOfCell("AG")] ? 1 : -1;
            });
        }

        return $data;
    }
}
