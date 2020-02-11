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
        $mode = $r->input("session-mode");
        $week = date("W");
        $year = date("Y");
        $month = strtoupper(date("M"));
        $scoreitems = ScoreItem::where("score_item_role", $role)->get();
        $colIndex = -1;
        $path = "data/$mode/$year/$month/$lead.xlsx";

        if (file_exists($path)) {
            $reader = new Xlsx;
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);
            $spreadsheet->setActiveSheetIndex(1);
            $scorevalues = $spreadsheet->getActiveSheet()->toArray();
        
            for ($i = 0; $i < count($scorevalues); $i++) { 
                if ($scorevalues[$i] == $agent) {
                    $colIndex = $i;
                    break;
                }
            }
            if ($colIndex == -1) $scorevalues = null;
        } else {
            $scorevalues = null;
        }
        
        return view('session')->with([
            "lead" => $lead,
            "agent" => $agent,
            "role" => $role,
            "type" => $type,
            "mode" => $mode != "" ? "manual" : "actual",
            "week" => $week,
            "scoreitems" => $scoreitems,
            "scorevalues" => $scorevalues,
            "columnindex" => $colIndex
        ]);
    }
}
