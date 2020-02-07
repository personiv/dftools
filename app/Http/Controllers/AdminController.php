<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Credential;
use App\ScoreItem;

class AdminController extends Controller {
    function addCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        $userType = $r->input("user-type");
        if (Credential::where("credential_user", $userId)->count() < 1) {
            $account = new Credential;
            $account->setAttribute("credential_user", $userId);
            $account->setAttribute("credential_pass", $userPass);
            $account->setAttribute("credential_type", $userType);
            $account->save();
            return back()->with(["msg" => "Credential created", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential already exists");
        }
    }

    function updateCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        $userType = $r->input("user-type");

        $selected = Credential::where('credential_user', $userId)->first();
        if ($selected != null) {
            if ($userPass != "") $selected->setAttribute("credential_pass", $userPass);
            $selected->setAttribute("credential_type", $userType);
            $selected->save();
            return back()->with(["msg" => "Credential updated", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential not registered");
        }
    }

    function deleteCredential(Request $r) {
        $userId = $r->input("user-id");

        $selected = Credential::where('credential_user', $userId)->first();
        if ($selected != null) {
            $selected->delete();
            return back()->with(["msg" => "Credential deleted", "msg-mood" => "good"]);
        } else {
            return back()->with("msg", "Credential not registered");
        }
    }

    function filterScoreItemByRole(Request $r) {
        // Filter scorecard items by role
        $selectedRole = $r->input("item-role");
        $scoreItems = ScoreItem::where('score_item_role', $selectedRole)->get();
        return back()->with(["selected-role" => $selectedRole, "score-items" => $scoreItems]);
    }

    function saveScoreItem(Request $r) {
        $data = json_decode($r->getContent(), true);
        $newItem = new ScoreItem;
        $newItem->setAttribute("score_item_role", $data["role"]);
        $newItem->setAttribute("score_item_name", $data["name"]);
        $newItem->setAttribute("score_item_desc", $data["description"]);
        $newItem->setAttribute("score_item_goal", $data["goal"]);
        $newItem->setAttribute("score_item_weight", $data["weight"]);
        $newItem->save();
        return $newItem->getAttribute("score_item_id");
    }

    function updateScoreItem(Request $r) {
        $data = json_decode($r->getContent(), true);
        $id = $data["id"];
        $columnName = $data["column"];
        $newValue = $data["value"];
        $rowToUpdate = ScoreItem::where("score_item_id", $id)->first();
        $rowToUpdate->setAttribute($columnName, $newValue);
        $rowToUpdate->save();
    }

    function deleteScoreItem(Request $r) {
        $id = json_decode($r->getContent(), true)["id"];
        $rowToDelete = ScoreItem::where("score_item_id", $id);
        $rowToDelete->delete();
    }

    function saveManualData(Request $r) {
        $year = $r->input("data-year");
        $month = $r->input("data-month");
        $team = $r->input("data-team");
        $src = $r->input("data-src");
        $folderpath = "data/$year/$month/";
        $filename = "$team.xlsx";
        if (!file_exists($folderpath)) mkdir($folderpath, 0777, true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Year');
        $sheet->setCellValue('B1', 'Month');
        $sheet->setCellValue('C1', 'Team');
        $sheet->setCellValue('A2', $year);
        $sheet->setCellValue('B2', $month);
        $sheet->setCellValue('C2', $team);
        $writer = new Xlsx($spreadsheet);
        $writer->save($folderpath . $filename);
        return back();
    }

    function readManualData(Request $r) {
        $year = $r->input("data-year");
        $month = $r->input("data-month");
        $team = $r->input("data-team");
        $src = $r->input("data-src");

        $reader = new Xlsx;
        $reader->setReadDataOnly(true);
        return $reader->load("data/$year/$month/$team.xlsx");
    }
}
