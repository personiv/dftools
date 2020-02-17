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
    const UNSIGNEDVERBIAGE = "On hold.";
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
    function IsSignee($employeeID) { return array_key_exists($employeeID, $this->Data()["signatures"]); }
    function IsSigned($employeeID) { return $this->Data()["signatures"][$employeeID]; }
    function IsNextSignee($employeeID) { return array_keys($this->Data()["signatures"])[$this->PendingLevel()] == $employeeID; }

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

        // Verify if the sender is authorized through password validation
        if ($r->session()->get("user")->Password() != $r->input("session-verify-password")) return;

        // Check if the userID exists in signees and if the userID is signing in proper order
        if (!$this->IsSignee($userID) || !$this->IsNextSignee($userID)) return;
        
        // Finally sign the user's part
        $data["signatures"][$userID] = true;

        // Unique Fields
        switch ($this->Type()) {
            case 'SCORE':
                if ($userID == $this->AgentID())
                    $data["fields"]["notes"]["value"] = $r->input("session-notes");
                break;
        }

        $this->setAttribute("session_data", $data);
        $this->save();
    }

    function Data() {
        // Get JSON saved in database in array form
        return $this->getAttribute("session_data");
    }

    protected function GenerateScorecardData() {
        if ($this->Agent() == null) return null;
        $year = $this->Year();
        $month = $this->Month();
        $supervisorID = $this->Agent()->TeamLeader()->EmployeeID();
        $path = $this->Mode() == "manual" ? "data/manual/$year/$month/$supervisorID.xlsx" : "data/actual/$year/$month.xlsx";
        
        $scorecard = ScoreItem::where("score_item_role", $this->Agent()->AccountType())->get();
        $agentvalues = array();
        if (file_exists($path)) {
            $reader = new Xlsx;
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);

            switch ($this->Mode()) {
                case 'manual':
                    $spreadsheet->setActiveSheetIndexByName($this->AgentRole());
                    $scorevalues = $spreadsheet->getActiveSheet()->toArray();

                    for ($i = 0; $i < count($scorevalues); $i++) 
                        if ($scorevalues[$i][0] == $this->AgentID())
                            $agentvalues = $scorevalues[$i];

                    for ($i = 0; $i < $scorecard->count(); $i++) {
                        if (!empty($agentvalues)) {
                            $scorecard[$i]["score_item_actual"] = $agentvalues[$i + 1];
                            $scorecard[$i]["score_item_overall"] = $agentvalues[$scorecard->count() + 1];
                        } else {
                            $scorecard[$i]["score_item_actual"] = "NaN";
                            $scorecard[$i]["score_item_overall"] = "NaN";
                        }
                    }
                    break;
                case 'actual':
                    $spreadsheet->setActiveSheetIndexByName("RESOURCES");
                    $scorevalues = $spreadsheet->getActiveSheet()->toArray();

                    for ($i = 0; $i < count($scorevalues); $i++)
                        if ($scorevalues[$i][2] == $this->AgentID())
                            $agentvalues = $scorevalues[$i];
                    
                    function IndexOfCell($columnName) {
                        $columnName = strtoupper($columnName);
                        $value = 0;
                        for ($i = 0; $i < strlen($columnName); $i++) {
                            $delta = ord($columnName[$i]) - 64;
                            $value = $value * 26 + $delta;
                        }
                        return $value - 1;
                    }

                    $links = ["W", "Y", "X", "AB", "AC", "AF"];
                    for ($i = 0; $i < $scorecard->count(); $i++) {
                        if (!empty($agentvalues)) {
                            $actual = $agentvalues[IndexOfCell($links[$i])];
                            $overall = $agentvalues[IndexOfCell("AG")];
                            if (is_numeric($actual)) $actual = round($actual * 100, 2);
                            if (is_numeric($overall)) $overall = round($overall * 100, 2);
                            $scorecard[$i]["score_item_actual"] = $actual;
                            $scorecard[$i]["score_item_overall"] = $overall;
                        } else {
                            $scorecard[$i]["score_item_actual"] = "NaN";
                            $scorecard[$i]["score_item_overall"] = "NaN";
                        }
                    }
                    break;
            }
        }
        return [
            "scorecard" => $scorecard,
            "fields" => [
                "notes" => [
                    "title" => "Notes",
                    "size" => 12, // Bootstrap grid size
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false,
                $this->Manager()->EmployeeID() => false,
                $this->Head()->EmployeeID() => false
            ]
        ];
    }

    protected function GenerateGoalSettingData() {
        if ($this->Agent() == null) return null;
        return [
            "scorecard_goal" => ScoreItem::where("score_item_role", $this->Agent()->AccountType())->get(),
            "fields" => [
                "notes" => [
                    "title" => "Notes",
                    "size" => 12, // Bootstrap grid size
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false,
                $this->Manager()->EmployeeID() => false,
                $this->Head()->EmployeeID() => false
            ]
        ];
    }

    function GenerateData() {
        $data = array();
        switch ($this->Type()) {
            case 'SCORE':
                $data = $session->GenerateScorecardData();
                break;
            case 'GOAL':
                $data = $session->GenerateGoalSettingData();
                break;
        }
        return $data;
    }

    function ExistingSession() {
        return Session::where("session_agent", $this->AgentID())->where("session_week", $this->Week())->first();
    }

    function ExistsThisWeek() {
        // Check if this session is a duplicated session this week
        return $this->ExistingSession() != null;
    }
}
