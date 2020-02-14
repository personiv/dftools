<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use App\Credential;
use App\ScoreItem;

class Session extends Model
{
    protected $primaryKey = 'session_id';
    protected $casts = ['session_compatible_data' => 'array'];

    const AGENTLEVEL = 0;
    const SUPERVISORLEVEL = 1;
    const MANAGERLEVEL = 2;
    const HEADLEVEL = 3;
    const DONELEVEL = 4;
    const SIGNVERBIAGE = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";

    function SessionID() { return $this->getAttribute("session_id"); }
    function DateCreated() { return $this->getAttribute("created_at"); }
    function AgentID() { return $this->getAttribute("session_agent"); }
    function AgentRole() { return $this->Agent()->getAttribute("credential_type"); }
    function Agent() { return Credential::where("credential_user", $this->getAttribute("session_agent"))->first(); }
    function Supervisor() { return $this->Agent()->TeamLeader(); }
    function Manager() { return $this->Supervisor()->TeamLeader(); }
    function Head() { return $this->Manager()->TeamLeader(); }
    function Type() { return $this->getAttribute("session_type"); }
    function Mode() { return $this->getAttribute("session_mode"); }
    function Year() { return $this->getAttribute("session_year"); }
    function Month() { return $this->getAttribute("session_month"); }
    function Day() { return $this->getAttribute("session_day"); }
    function Week() { return $this->getAttribute("session_week"); }

    function PendingLevel() {
        if ($this->getAttribute("session_agent_sign") == false) return self::AGENTLEVEL;
        else if ($this->getAttribute("session_supervisor_sign") == false) return self::SUPERVISORLEVEL;
        else if ($this->getAttribute("session_manager_sign") == false) return self::MANAGERLEVEL;
        else if ($this->getAttribute("session_head_sign") == false) return self::HEADLEVEL;
        else return self::DONELEVEL;
    }

    function MovePendingLevel(Request $r) {
        switch($this->PendingLevel()) {
            case self::AGENTLEVEL:
                if ($r->session()->get("user") != $this->Agent()->EmployeeID()) return;
                $this->setAttribute("session_agent_sign", true);
                break;
            case self::SUPERVISORLEVEL:
                if ($r->session()->get("user") != $this->Supervisor()->EmployeeID()) return;
                $this->setAttribute("session_supervisor_sign", true);
                break;
            case self::MANAGERLEVEL:
                if ($r->session()->get("user") != $this->Manager()->EmployeeID()) return;
                $this->setAttribute("session_manager_sign", true);
                break;
            case self::HEADLEVEL:
                if ($r->session()->get("user") != $this->Head()->EmployeeID()) return;
                $this->setAttribute("session_head_sign", true);
                break;
        }
        $this->save();
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

    function ExistingSession() {
        return Session::where("session_agent", $this->AgentID())->where("session_week", $this->Week())->first();
    }

    function ExistsThisWeek() {
        // Check if this session is a duplicated session this week
        return $this->ExistingSession() != null;
    }
}
