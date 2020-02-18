<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
    function TeamMembers() { return Credential::where("credential_up", $this->getAttribute("credential_user"))->get(); }
    function TeamLeader() { return Credential::where("credential_user", $this->getAttribute("credential_up"))->first(); }
    function Status() { return $this->getAttribute('credential_status') != null ? $this->getAttribute('credential_status') : "N/A"; }
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

    // Team Leader Methods
    function SessionsThisWeek() {
        $sessions = array();
        $weeksessions = Session::where("session_week", (int)date("W"))->get();
        for ($i=0; $i < count($weeksessions); $i++) { 
            if ($weeksessions[$i]->Agent()->TeamLeader()->EmployeeID() == $this->EmployeeID()) {
                array_push($sessions, $weeksessions[$i]);
            }
        }
        return $sessions;
    }

    function CoachingSummaryThisWeek() {
        $sessions = array("For Coaching" => [], "Pending" => [], "Completed" => []);
        $teamMembers = $this->TeamMembers();
        $weekSessions = $this->SessionsThisWeek();
        $exceptions = $this->ExceptionsThisWeek();
        
        // For Coaching iteration
        foreach ($teamMembers as $agent) {
            // Check first if this agent is in list of excepted
            $excepted = false;
            foreach ($exceptions as $exception)
                if ($exception->exception_agent == $agent->EmployeeID())
                    $excepted = true;

            // Skip this iteration for current agent
            if ($excepted) continue;

            // Check if this agent has session this week
            $hasSession = false;
            foreach ($weekSessions as $weekSession) {
                if ($agent->EmployeeID() == $weekSession->AgentID()) {
                    $hasSession = true;
                    break;
                }
            }

            // Only tag as [For Coaching] if this agent has no session this week and not excepted
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
            // Check first if this agent is in list of excepted
            $excepted = false;
            foreach ($exceptions as $exception)
                if ($exception->exception_agent == $agent->EmployeeID())
                    $excepted = true;

            // Skip this iteration for current agent
            if ($excepted) continue;

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
        return DB::table("exceptions")
                ->join("credentials", "exception_agent", "=", "credential_user")
                ->select("exception_id", "exception_agent", "exception_reason")
                ->where("exception_week", (int)date("W"))->where("credential_up", $this->EmployeeID())->get();
    }

    function TeamStackRank() {
        $data = array();
        $teamMembers = $this->TeamMembers();

        foreach ($teamMembers as $teamMember) {
            $actualData = Session::GetAgentActualData(date("Y"), date("M"), $teamMember->EmployeeID());
            array_push($data, [
                "agent" => self::GetCredential($teamMember->EmployeeID()),
                "productivity" => $actualData[Session::IndexOfCell("W")],
                "quality" => $actualData[Session::IndexOfCell("Y")],
                "churn" => $actualData[Session::IndexOfCell("X")],
                "pkt" => $actualData[Session::IndexOfCell("AB")],
                "attendance" => $actualData[Session::IndexOfCell("AC")],
                "bonus" => $actualData[Session::IndexOfCell("AF")],
                "overall" => $actualData[Session::IndexOfCell("AG")]
            ]);
        }

        usort($data, function($a, $b) {
            return $a["overall"] < $b["overall"] ? 1 : -1;
        });

        return $data;
    }
}
