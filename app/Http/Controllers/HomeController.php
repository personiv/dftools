<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Credential;
use App\ScoreItem;
use App\Session;

class HomeController extends Controller {
    function getExcelData($path, $sheetName, $agent) {
        if (file_exists($path)) {
            $reader = new Xlsx;
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);
            $spreadsheet->setActiveSheetIndexByName($sheetName);
            $scorevalues = $spreadsheet->getActiveSheet()->toArray();
        
            for ($i = 0; $i < count($scorevalues); $i++) 
                if ($scorevalues[$i][0] == $agent)
                    return $scorevalues[$i];
        }
        return array();
    }

    function getProficiency($date) {
        if ($date == null) return "N/A";
        $hireDate = date_create($date);
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

    function getFunctionName($role) {
        switch ($role) {
            case "DESGN": return "Web Designer";
            case "WML": return "Web Mods Line";
            case "VQA": return "Voice Quality Assurance";
            case "CUSTM": return "Senior Web Designer";
            case "PR": return "Website Proofreader";
            default: return "N/A";
        }
    }

    function session(Request $r) {
        $supervisor = $r->session()->get("user");
        $agent = $r->input("session-agent");
        $role = Credential::where("credential_user", $agent)->first()->getAttribute("credential_type");
        $type = $r->input("session-type");
        $mode = $r->input("session-mode") != "" ? "manual" : "actual";
        $date = explode("/", date("M/d/Y/W"));
        $year = $date[2];
        $month = strtoupper($date[0]);
        $week = $date[3];
        $path = $mode == "manual" ? "data/$mode/$year/$month/$supervisor.xlsx" : "data/$mode/$year/$month.xlsx";
        $sessiondata = [
            "scoreitems" => ScoreItem::where("score_item_role", $role)->get(),
            "scorevalues" => $this->getExcelData($path, $role, $agent)
        ];

        // Don't continue if the session already exists
        if (Session::where("session_agent", $agent)->where("session_week", $week)->count() > 0)
            return redirect()->route("dashboard");
        
        // Save to database as AGENT level pending session
        $session = new Session;
        $session->setAttribute("session_type", $type);
        $session->setAttribute("session_agent", $agent);
        $session->setAttribute("session_mode", $mode);
        $session->setAttribute("session_year", $year);
        $session->setAttribute("session_month", $month);
        $session->setAttribute("session_day", $date[1]);
        $session->setAttribute("session_week", $week);
        $session->setAttribute("session_data", $sessiondata);
        $session->save();
    
        $agentInfo = Credential::where("credential_user", $agent)->first();
        $supervisorInfo = Credential::where("credential_user", $supervisor)->first();
        $managerInfo = Credential::where("credential_user", $supervisorInfo->getAttribute("credential_up"))->first();
        $headInfo = Credential::where("credential_user", $managerInfo->getAttribute("credential_up"))->first();
        return view('session')->with([
            "agent" => $agentInfo,
            "supervisor" => $supervisorInfo,
            "manager" => $managerInfo,
            "head" => $headInfo,
            "data" => $session,
            "process" => $this->getFunctionName($role),
            "proficiency" => $this->getProficiency($agentInfo->getAttribute("credential_hire_date"))
        ]);
    }

    function getWeeklyPendingSessions(Request $r) {
        $data = json_decode($r->getContent(), true);
        $year = $data["year"];
        $week = $data["week"];
        $supervisor = $data["supervisor"];
        // TODO: code here....
    }
}
