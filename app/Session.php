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
    const UNSIGNEDVERBIAGE = "Not yet reviewed";
    const PENDINGVERBIAGE = "Unable to sign yet";
    const SIGNEDVERBIAGE = "I have reviewed this document and hereby certify the the above information is true and correct";
    static function IndexOfCell($columnName) {
        $columnName = strtoupper($columnName);
        $value = 0;
        for ($i = 0; $i < strlen($columnName); $i++) {
            $delta = ord($columnName[$i]) - 64;
            $value = $value * 26 + $delta;
        }
        return $value - 1;
    }
    static function GetRowData($year, $month, $agentID, $agentIDCell, $sheetName, $supervisorID = "") {
        if ($supervisorID == "") $path = "data/actual/$year/$month.xlsx";
        else $path = "data/manual/$year/$month/$supervisorID.xlsx";
        if (!file_exists($path)) return array();

        $reader = new Xlsx;
        $reader->setReadDataOnly(true);
        $reader->setLoadSheetsOnly($sheetName);
        $reader->setReadFilter(new SheetFilter(range(self::IndexOfCell('A'), self::IndexOfCell('AS'))));
        $spreadsheet = $reader->load($path);
        $spreadsheet->setActiveSheetIndexByName($sheetName);
        $scorevalues = $spreadsheet->getActiveSheet()->toArray();

        for ($i = 0; $i < count($scorevalues); $i++) {
            if ($scorevalues[$i][self::IndexOfCell($agentIDCell)] == $agentID) {
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
    // HARD-CODED Senior OM Employee ID!
    // function SeniorOM() { return Credential::where("credential_user", 10072003)->first(); }
    // ----
    function Head() { return $this->Manager()->TeamLeader(); }
    function Signees() { return $this->Data()["signatures"]; }
    function IsSignee($employeeID) { return array_key_exists($employeeID, $this->Data()["signatures"]); }
    function SigneeLevel($employeeID) {
        $c = 0;
        foreach ($this->Data()["signatures"] as $id => $signed) {
            if ($employeeID == $id) return $c;
            $c++;
        }
        return -1;
    }
    function IsSigned($employeeID) { return $this->Data()["signatures"][$employeeID]; }
    function IsNextSignee($employeeID) {
        if (count(array_keys($this->Signees())) > $this->PendingLevel())
            return array_keys($this->Signees())[$this->PendingLevel()] == $employeeID;
        else return false;
    }

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
        if ($r->session()->get("user")->Password() != $r->input("session-verify-password")) return false;

        // Check if the userID exists in signees and if the userID is signing in proper order
        if (!$this->IsSignee($userID) || !$this->IsNextSignee($userID)) return false;
        
        // Finally sign the user's part
        $data["signatures"][$userID] = true;
        $data["signDates"][$userID] = date("m/d/Y");

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
        return true;
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
        $data["signDates"][$writerIndex] = null;
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

    protected function GenerateScorecardData($wholeMonth = false) {
        if ($this->Agent() == null) return null;
        $year = $this->Year();
        $month = $this->Month();
        
        $scorecard = ScoreItem::where("score_item_role", $this->Agent()->AccountType())->get();
        $agentvalues = array();
        switch ($this->Mode()) {
            case 'manual':
                $agentvalues = self::GetRowData($year, $month, $this->AgentID(), 'A', $this->AgentRole(), $this->Supervisor()->EmployeeID());
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
                $agentvalues = self::GetRowData($year, $month, $this->AgentID(), 'C', "RESOURCES");
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
        return [
            "scorecard" => $scorecard,
            "isWholeMonth" => $wholeMonth,
            "fields" => [
                "action" => [
                    "title" => "Action Plan/s",
                    "size" => 12, // Bootstrap grid size
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
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
                    "height" => 32, // In pixel
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false
            ], "signDates" => [
                // Date signed to be displayed beside signature
                $this->Agent()->EmployeeID() => null,
                $this->Supervisor()->EmployeeID() => null
            ]
        ];
    }

    protected function GenerateGoalSettingData() {
        if ($this->Agent() == null) return null;
        return [
            "scorecardGoal" => ScoreItem::where("score_item_role", $this->Agent()->AccountType())->get(),
            "fields" => [
                "action" => [
                    "title" => "Action Plan/s",
                    "size" => 12, // Bootstrap grid size
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
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
                    "height" => 32, // In pixel
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false
            ], "signDates" => [
                // Date signed to be displayed beside signature
                $this->Agent()->EmployeeID() => null,
                $this->Supervisor()->EmployeeID() => null
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
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
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
                    "height" => 32, // In pixel
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false
            ], "signDates" => [
                // Date signed to be displayed beside signature
                $this->Agent()->EmployeeID() => null,
                $this->Supervisor()->EmployeeID() => null
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
                    "for" => $this->Supervisor()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0, // Pending Level where this input is active
                    "instant" => true // If the input is instantly saved after onchange event without signing
                ],
                "improve" => [
                    "title" => "Areas of Improvement",
                    "size" => 6, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Supervisor()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0, // Pending Level where this input is active
                    "placeholder" => "Optional", // Add placeholder 'Optional' for the input
                    "instant" => true // If the input is instantly saved after onchange event without signing
                ],
                "action" => [
                    "title" => "Action Plan",
                    "size" => 12, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ],
                "commit" => [
                    "title" => "Commitment",
                    "size" => 12, // Bootstrap grid size
                    "height" => 100, // In pixel
                    "value" => "",
                    "for" => $this->Agent()->EmployeeID(), // Employee who can edit the input
                    "pending" => 0 // Pending Level where this input is active
                ]
            ], "signatures" => [
                $this->Agent()->EmployeeID() => false,
                $this->Supervisor()->EmployeeID() => false,
                $this->Manager()->EmployeeID() => false
            ], "signDates" => [
                // Date signed to be displayed beside signature
                $this->Agent()->EmployeeID() => null,
                $this->Supervisor()->EmployeeID() => null,
                $this->Manager()->EmployeeID() => null
            ], "altRoles" => [
                // HARD-CODED Senior OM Alternate Role!
                // Alternative title to be displayed on the session views on signees section
                null,
                "Operations Manager/Senior OM",
                null
            ]
        ];
    }

    function GenerateData() {
        $data = array();
        switch ($this->Type()) {
            case 'SCORE':
                $data = $this->GenerateScorecardData();
                break;
            case 'SCORE2':
                $data = $this->GenerateScorecardData(true);
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
