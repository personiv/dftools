<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Session;
use App\Tag;

class Credential extends Model
{
    protected $primaryKey = 'credential_id';
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
        for ($i = 0; $i < $teamMembers->count(); $i++) { 
            $teamMember = $teamMembers[$i];
            $hasSession = false;
            for ($j = 0; $j < count($weekSessions); $j++) {
                $weekSession = $weekSessions[$j];
                if ($teamMember->EmployeeID() == $weekSession->AgentID()) {
                    $hasSession = true;
                    break;
                }
            }
            if (!$hasSession) {
                array_push($sessions["For Coaching"], [
                    "employeeID" => $teamMember->EmployeeID(),
                    "fullName" => $teamMember->FullName(),
                    "jobPosition" => $teamMember->JobPosition()
                ]);
            } else {
                if ($weekSession->IsSignee($this->EmployeeID()) && !$weekSession->IsSigned($this->EmployeeID())) {
                    array_push($sessions["Pending"], [
                        "employeeID" => $teamMember->EmployeeID(),
                        "fullName" => $teamMember->FullName(),
                        "jobPosition" => $teamMember->JobPosition(),
                        "sessionID" => $weekSession->SessionID()
                    ]);
                } else if ($weekSession->IsSignee($this->EmployeeID()) && $weekSession->IsSigned($this->EmployeeID())) {
                    array_push($sessions["Completed"], [
                        "employeeID" => $teamMember->EmployeeID(),
                        "fullName" => $teamMember->FullName(),
                        "jobPosition" => $teamMember->JobPosition()
                    ]);
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

    function TeamStackRank() {

    }
}
