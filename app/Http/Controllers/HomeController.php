<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\ScoreItem;

class HomeController extends Controller {
    function session(Request $r) {
        $lead = "10071309";
        $agent = $r->session()->get("user");
        $role = $r->session()->get("user-type");
        $type = "SCORE";
        $mode = "manual";
        $week = date("W");
        $year = date("Y");
        $month = strtoupper(date("M"));
        $scoreitems = ScoreItem::where("score_item_role", $role)->get();
        $colIndex = -1;

        if (file_exists("data/$mode/$year/$month/$lead.xlsx")) {
            $reader = new Xlsx;
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load("data/$mode/$year/$month/$lead.xlsx");
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
            "mode" => $mode,
            "week" => $week,
            "scoreitems" => $scoreitems,
            "scorevalues" => $scorevalues,
            "columnindex" => $colIndex
        ]);
    }
}
