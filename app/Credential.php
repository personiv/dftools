<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Session;

class Credential extends Model
{
    protected $primaryKey = 'credential_id';

    function EmployeeID() { return $this->getAttribute("credential_user"); }
    function Password() { return $this->getAttribute("credential_pass"); }
    function AccountType() { return $this->getAttribute("credential_type"); }
    function FirstName() { return $this->getAttribute("credential_first"); }
    function LastName() { return $this->getAttribute("credential_last"); }
    function FullName() { return $this->getAttribute("credential_first") . ' ' . $this->getAttribute("credential_last"); }
    function TeamMembers() { return Credential::where("credential_up", $this->getAttribute("credential_user"))->get() ?? []; }
    function TeamLeader() { return Credential::where("credential_user", $this->getAttribute("credential_up"))->first(); }
    function Status() { return $this->getAttribute('credential_status') != null ? $this->getAttribute('credential_status') : "N/A"; }
    function IsAdmin() { return $this->getAttribute("credential_type") == "ADMIN"; }
    function IsLeader() { return $this->TeamMembers() != []; }

    function JobPosition() {
        switch ($this->getAttribute("credential_type")) {
            case "DESGN": return "Web Designer";
            case "WML": return "Web Mods Line";
            case "VQA": return "Voice Quality Assurance";
            case "CUSTM": return "Senior Web Designer";
            case "PR": return "Website Proofreader";
            case "SPRVR": return "Supervisor";
            case "MANGR": return "Operation Manager";
            case "HEAD": return "Operation Head";
            case "ADMIN": return "Administrator";
            default: return "N/A";
        }
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

    // Supervisor Methods
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

    function PendingCoachingThisWeek() {
        $sessions = array();
        $weeksessions = $this->SessionsThisWeek();
        for ($i=0; $i < count($weeksessions); $i++) {
            switch ($this->AccountType()) {
                default:
                    if ($weeksessions[$i]->PendingLevel() < $weeksessions[$i]::SUPERVISORLEVEL) array_push($sessions, $weeksessions[$i]);
                    break;
                case "SPRVR":
                    if ($weeksessions[$i]->PendingLevel() < $weeksessions[$i]::MANAGERLEVEL) array_push($sessions, $weeksessions[$i]);
                    break;
                case "MANGR":
                    if ($weeksessions[$i]->PendingLevel() < $weeksessions[$i]::HEADLEVEL) array_push($sessions, $weeksessions[$i]);
                    break;
                case "HEAD":
                    if ($weeksessions[$i]->PendingLevel() < $weeksessions[$i]::DONELEVEL) array_push($sessions, $weeksessions[$i]);
                    break;
            }
        }
        return $sessions;
    }

    function CompletedCoachingThisWeek() {
        $sessions = array();
        $weeksessions = $this->SessionsThisWeek();
        for ($i=0; $i < count($weeksessions); $i++) {
            $weeksession = $weeksessions[$i];
            switch ($this->AccountType()) {
                case "SPRVR":
                    if ($weeksessions[$i]->PendingLevel() > $weeksession::SUPERVISORLEVEL) array_push($sessions, $weeksession);
                    break;
                case "MANGR":
                    if ($weeksessions[$i]->PendingLevel() > $weeksession::MANAGERLEVEL) array_push($sessions, $weeksession);
                    break;
                case "HEAD":
                    if ($weeksessions[$i]->PendingLevel() > $weeksession::HEADLEVEL) array_push($sessions, $weeksession);
                    break;
            }
        }
        return $sessions;
    }
}
