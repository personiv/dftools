<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Credential;
use App\ScoreItem;

class Session extends Model
{
    protected $primaryKey = 'session_id';
    protected $casts = ['session_compatible_data' => 'array'];

    function DateCreated() { return $this->getAttribute("created_at"); }
    function AgentID() { return $this->getAttribute("session_agent"); }
    function AgentRole() { return $this->Agent()->getAttribute("credential_type"); }
    function Agent() { return Credential::where("credential_user", $this->getAttribute("session_agent"))->first(); }
    function Type() { return $this->getAttribute("session_type"); }
    function Mode() { return $this->getAttribute("session_mode"); }
    function Year() { return $this->getAttribute("session_year"); }
    function Month() { return $this->getAttribute("session_month"); }
    function Day() { return $this->getAttribute("session_day"); }
    function Week() { return $this->getAttribute("session_week"); }

    function PendingLevel() {
        if ($this->getAttribute("session_agent_sign") == false || $this->getAttribute("session_notes") == "") return 1;
        else if ($this->getAttribute("session_supervisor_sign") == false) return 2;
        else if ($this->getAttribute("session_manager_sign") == false) return 3;
        else if ($this->getAttribute("session_head_sign") == false) return 4;
        else return 5;
    }

    function CompatibleData() {
        // Get JSON saved in database in array form
        return $this->getAttribute("session_compatible_data");
    }

    function Data() {
        if ($this->Agent() == null) return [ "items" => array(), "values" => array() ];
        $year = $this->Year();
        $month = $this->Month();
        $supervisorID = $this->Agent()->TeamLeader()->EmployeeID();
        $path = $this->Mode() == "manual" ? "data/manual/$year/$month/$supervisorID.xlsx" : "data/actual/$year/$month.xlsx";
        $agentvalues = array();
        if (file_exists($path)) {
            $reader = new Xlsx;
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);
            $spreadsheet->setActiveSheetIndexByName($this->AgentRole());
            $scorevalues = $spreadsheet->getActiveSheet()->toArray();
        
            for ($i = 0; $i < count($scorevalues); $i++) 
                if ($scorevalues[$i][0] == $this->AgentID())
                    $agentvalues = $scorevalues[$i];
        }
        return ["items" => ScoreItem::where("score_item_role", $this->Agent()->getAttribute("credential_type"))->get(), "values" => $agentvalues];
    }

    function ExistsThisWeek() {
        // Check if this session is a duplicated session this week
        return Session::where("session_agent", $this->AgentID())->where("session_week", $this->Week())->count() > 1;
    }
}
