<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $primaryKey = 'credential_id';

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
}
