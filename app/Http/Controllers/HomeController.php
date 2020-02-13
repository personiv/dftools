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
        
        return view('session')->with(["agent" => Credential::where("credential_user", $agent)->first(), "data" => $session]);
    }
}
