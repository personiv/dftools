<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Credential;
use App\ScoreItem;

class HomeController extends Controller {
    function session(Request $r) {
        $lead = $r->session()->get("user");
        $agent = $r->input("session-agent");
        $role = Credential::where("credential_user", $agent)->first()->getAttribute("credential_type");
        $type = $r->input("session-type");
        $mode = $r->input("session-mode") != "" ? "manual" : "actual";
        $week = date("W");
        $year = date("Y");
        $month = strtoupper(date("M"));
        $scoreitems = ScoreItem::where("score_item_role", $role)->get();
        $colIndex = -1;
        if ($mode == "manual") $path = "data/$mode/$year/$month/$lead.xlsx";
        else $path = "data/$mode/$year/$month.xlsx";

        if (file_exists($path)) {
            $reader = new Xlsx;
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);
            $spreadsheet->setActiveSheetIndexByName($role);
            $scorevalues = $spreadsheet->getActiveSheet()->toArray();
        
            for ($i = 0; $i < count($scorevalues); $i++) { 
                if ($scorevalues[$i][0] == $agent) {
                    $colIndex = $i;
                    break;
                }
            }
            if ($colIndex == -1) $scorevalues = array();
        } else {
            $scorevalues = array();
        }
        $sessiondata = [
            "lead" => $lead,
            "agent" => $agent,
            "role" => $role,
            "type" => $type,
            "mode" => $mode,
            "week" => $week,
            "scoreitems" => $scoreitems,
            "scorevalues" => $scorevalues,
            "columnindex" => $colIndex,
            "agent_sign" => false,
            "supervisor_sign" => false,
            "manager_sign" => false,
            "head_sign" => false
        ];

        // Save to week number folder
        $sessionpath = "data/sessions/$year/$month/$week/";
        $sessionfile = "$agent.json";
        if (!file_exists($sessionpath)) mkdir($sessionpath, 0777, true);
        file_put_contents($sessionpath . $sessionfile, json_encode($sessiondata));

        return view('session')->with($sessiondata);
    }
}
