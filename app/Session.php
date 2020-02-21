<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Session extends Model
{
    protected $primaryKey = 'session_id';
    protected $casts = ['session_data' => 'array'];
    const UNSIGNEDVERBIAGE = "On hold.";
    const PENDINGVERBIAGE = "Unable to sign yet.";
    const SIGNEDVERBIAGE = "Lorem ipsum dolor sit amet, consectetur adipiscing elit.";
    static function IndexOfCell($columnName) {
        $columnName = strtoupper($columnName);
        $value = 0;
        for ($i = 0; $i < strlen($columnName); $i++) {
            $delta = ord($columnName[$i]) - 64;
            $value = $value * 26 + $delta;
        }
        return $value - 1;
    }
    static function GetAgentActualData($year, $month, $agentID) {
        $reader = new Xlsx;
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly(["RESOURCES"]);
        $spreadsheet = $reader->load("data/actual/$year/$month.xlsx");
        $spreadsheet->setActiveSheetIndexByName("RESOURCES");
        $scorevalues = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 0; $i < count($scorevalues); $i++) {
            if ($scorevalues[$i][2] == $agentID) {
                return $scorevalues[$i];
            }
        }
        return array();
    }

    function SessionID() { return $this->getAttribute("session_id"); }
    function DateCreated() { return $this->getAttribute("created_at"); }
    function AgentID() { return $this->getAttribute("session_agent"); }
    function AgentRole() { return $this->Agent()->getAttribute("credential_type"); }
    function Type() { return $this->getAttribute("session_type"); }
    function TypeDescription() { return Tag::where("tag_name", $this->getAttribute("session_type"))->first()->Description(); }
    function Mode() { return $this->getAttribute("session_mode"); }
    function Year() { return $this->getAttribute("session_year"); }
    function Month() { return $this->getAttribute("session_month"); }
    function Day() { return $this->getAttribute("session_day"); }
    function Week() { return $this->getAttribute("session_week"); }

    function Agent() { return Credential::where("credential_user", $this->getAttribute("session_agent"))->first(); }
    function Supervisor() { return $this->Agent()->TeamLeader(); }
    function Manager() { return $this->Supervisor()->TeamLeader(); }
    function Head() { return $this->Manager()->TeamLeader(); }
    function Signees() { return $this->Data()["signatures"]; }
    function IsSignee($employeeID) { return array_key_exists($employeeID, $this->Data()["signatures"]); }
    function SigneeLevel($employeeID) { return array_keys($this->Data()["signatures"], $employeeID)[0]; }
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

        // Save the non-instant field values along with the user's signature
        if (array_key_exists("fields", $data)) {
            foreach ($data["fields"] as $fieldName => $fieldProperties) {
                if (!array_key_exists("instant", $fieldProperties) || !$fieldProperties["instant"]) {
                    if ($userID == $this->AgentID()) $data["fields"][$fieldName]["value"] = $r->input("session-${fieldName}");
                }
            }
        }

        $this->setAttribute("session_data", $data);
        $this->save();
    }

    function ResetPending(Request $r) {
        $data = $this->Data();
        $userID = $r->session()->get("user")->EmployeeID();
        $fieldName = $r->input("session-field");
        $fieldPendingLevel = $r->input("session-pending");
        $writerIndex = array_keys($data["signatures"])[$fieldPendingLevel];

        // Check if the userID exists in signees to authorize the process
        if (!$this->IsSignee($userID)) return;

        // Finally unsign the user's part and clear the field
        $data["signatures"][$writerIndex] = false;
        $data["fields"][$fieldName]["value"] = "";

        $this->setAttribute("session_data", $data);
        $this->save();
    }

    function updateField(Request $r, $jsonData) {
        $data = $this->Data();
        $userID = $r->session()->get("user")->EmployeeID();
        $fieldName = $jsonData["fieldName"];
        $fieldValue = $jsonData["fieldValue"];

        // Check if the userID exists in signees to authorize the process
        if (!$this->IsSignee($userID)) return;

        // Finally change the field's value
        $data["fields"][$fieldName]["value"] = $fieldValue;

        $this->setAttribute("session_data", $data);
        $this->save();
    }

    function Data() {
        // Get JSON saved in database in array form
        return $this->getAttribute("session_data");
    }

    static function GetActualDataRow($employeeID, $year, $month, $sheetName) {
        $reader = new Xlsx;
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly([$sheetName]);
        $spreadsheet = $reader->load("data/actual/$year/$month.xlsx");
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $scorevalues = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 0; $i < count($scorevalues); $i++) {
            if ($scorevalues[$i][1] == $employeeID) {
                return $scorevalues[$i];
            }
        }
        return array();
    }

    static function GetActualDataCellValue($employeeID, $year, $month, $sheetName, $cellName) {
        return self::GetActualDataRow($employeeID, $year, $month, $sheetName)[self::IndexOfCell($cellName)];
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
            switch ($this->Mode()) {
                case 'manual':
                    $reader = new Xlsx;
                    $reader->setReadDataOnly(true);
                    $spreadsheet = $reader->load($path);
                    $spreadsheet->setActiveSheetIndexByName($this->AgentRole());
                    $scorevalues = $spreadsheet->getActiveSheet()->toArray();

                    for ($i = 0; $i < count($scorevalues); $i++) {
                        if ($scorevalues[$i][0] == $this->AgentID()) {
                            $agentvalues = $scorevalues[$i];
                            break;
                        }
                    }

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
                    $agentvalues = self::GetAgentActualData($year, $month, $this->AgentID());
                    for ($i = 0; $i < $scorecard->count(); $i++) {
                        if (!empty($agentvalues)) {
                            $actual = $agentvalues[self::IndexOfCell($scorecard[$i]["score_item_cell"])];
                            $overall = $agentvalues[self::IndexOfCell("AG")];
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
            "scorecardGoal" => ScoreItem::where("score_item_role", $this->Agent()->AccountType())->get(),
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

    protected function GenerateCoachingData() {
        if ($this->Agent() == null) return null;
        return [
            "fields" => [
                "strnopr" => [
                    "title" => "Strengths & Opportunities",
                    "size" => 12, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Supervisor()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0, // Pending Level where this input is active
                    "instant" => true // If the input is instantly saved after onchange event without signing
                ],
                "action" => [
                    "title" => "Action Plan/s",
                    "size" => 12, // Bootstrap grid size
                    "value" => "",
                    "for" => $this->Supervisor()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0, // Pending Level where this input is active
                    "instant" => true // If the input is instantly saved after onchange event without signing
                ],
                "commit" => [
                    "title" => "Commitments & Targets",
                    "size" => 12, // Bootstrap grid size
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ],
                "follow" => [
                    "title" => "Follow Up Date",
                    "size" => 12, // Bootstrap grid size
                    "height" => 50, // In pixel
                    "value" => "",
                    "for" => $this->Supervisor()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0, // Pending Level where this input is active
                    "instant" => true // If the input is instantly saved after onchange event without signing
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false
            ]
        ];
    }

    protected function GenerateTriadData() {
        if ($this->Agent() == null) return null;
        return [
            "fields" => [
                "strength" => [
                    "title" => "Strength",
                    "size" => 6, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Manager()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ],
                "improve" => [
                    "title" => "Areas of Improvement",
                    "size" => 6, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Manager()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ],
                "action" => [
                    "title" => "Action Plan",
                    "size" => 12, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Manager()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ],
                "commit" => [
                    "title" => "Commitment",
                    "size" => 12, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Supervisor()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Supervisor()->EmployeeID() => false,
                $this->Manager()->EmployeeID() => false,
                // $this->SeniorOM()->EmployeeID() => false,
                $this->Head()->EmployeeID() => false
            ]
        ];
    }

    function GenerateData() {
        $data = array();
        switch ($this->Type()) {
            case 'SCORE':
                $data = $this->GenerateScorecardData();
                break;
            case 'GOAL':
                $data = $this->GenerateGoalSettingData();
                break;
            case 'COACH':
                $data = $this->GenerateCoachingData();
                break;
            case 'TRIAD':
                $data = $this->GenerateTriadData();
                break;
            default:
                $data = [
                    "signatures" => [
                        $this->Agent()->EmployeeID() => false,
                        $this->Supervisor()->EmployeeID() => false
                    ]
                ];
                break;
        }
        return $data;
    }

    function ExistingSession() {
        return self::where("session_agent", $this->AgentID())
            ->where("session_week", $this->Week())
            ->where("session_type", $this->Type())->first();
    }

    function ExistsThisWeek() {
        // Check if this session is a duplicated session this week
        return $this->ExistingSession() != null;
    }
}
