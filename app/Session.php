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
    protected $casts = ['session_data' => 'array'];
    const UNSIGNEDVERBIAGE = "Not yet signed.";
    const PENDINGVERBIAGE = "Unable to sign yet.";
    const SIGNEDVERBIAGE = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";

    function SessionID() { return $this->getAttribute("session_id"); }
    function DateCreated() { return $this->getAttribute("created_at"); }
    function AgentID() { return $this->getAttribute("session_agent"); }
    function AgentRole() { return $this->Agent()->getAttribute("credential_type"); }
    function Type() { return $this->getAttribute("session_type"); }
    function Mode() { return $this->getAttribute("session_mode"); }
    function Year() { return $this->getAttribute("session_year"); }
    function Month() { return $this->getAttribute("session_month"); }
    function Day() { return $this->getAttribute("session_day"); }
    function Week() { return $this->getAttribute("session_week"); }

    function Agent() { return Credential::where("credential_user", $this->getAttribute("session_agent"))->first(); }
    function Supervisor() { return $this->Agent()->TeamLeader(); }
    function Manager() { return $this->Supervisor()->TeamLeader(); }
    function Head() { return $this->Manager()->TeamLeader(); }

    function PendingLevel() {
        $level = 0;
        $signatures = $this->Data()["signatures"];
        foreach ($signatures as $employeeID => $signed) {
            if (!$signed) break;
            $level++;
        }
        return $level;
    }

    function MovePendingLevel(Request $r) {
        $data = $this->Data();
        $userID = $r->session()->get("user")->EmployeeID();

        // Check if the userID exists in signees and if the userID is signing in proper order
        if (!array_key_exists($userID, $data["signatures"]) ||
            array_keys($data["signatures"])[$this->PendingLevel()] != $userID) return;
        
        // Proceed with the update
        $data["signatures"][$userID] = true;
        $this->setAttribute("session_data", $data);
        $this->save();
    }

    function Data() {
        // Get JSON saved in database in array form
        return $this->getAttribute("session_data");
    }

    function GenerateScorecardData() {
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
        return [
            "items" => ScoreItem::where("score_item_role", $this->Agent()->AccountType())->get(),
            "values" => $agentvalues,
            "fields" => [
                "notes" => ""
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false,
                $this->Manager()->EmployeeID() => false,
                $this->Head()->EmployeeID() => false
            ]
        ];
    }

    function ExistingSession() {
        return Session::where("session_agent", $this->AgentID())->where("session_week", $this->Week())->first();
    }

    function ExistsThisWeek() {
        // Check if this session is a duplicated session this week
        return $this->ExistingSession() != null;
    }
}
