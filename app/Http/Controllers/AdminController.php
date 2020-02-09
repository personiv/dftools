<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Credential;
use App\ScoreItem;

class AdminController extends Controller {
    function viewAddCredential(Request $r) {
        $leaders = Credential::where("credential_type", "HEAD")
            ->orWhere("credential_type", "MANGR")
            ->orWhere("credential_type", "SPRVR")->get();
        return view("admin.addcredential")->with(["leaders" => $leaders]);
    }

    function addCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        $userFirst = $r->input("user-first");
        $userLast = $r->input("user-last");
        $userType = $r->input("user-type");
        $userUp = $r->input("user-up");
        if (Credential::where("credential_user", $userId)->count() < 1) {
            $account = new Credential;
            $account->setAttribute("credential_user", $userId);
            $account->setAttribute("credential_pass", $userPass);
            $account->setAttribute("credential_first", $userFirst);
            $account->setAttribute("credential_last", $userLast);
            $account->setAttribute("credential_type", $userType);
            $account->setAttribute("credential_up", $userUp);
            $account->save();
            return back()->with(["msg" => "Credential created", "msg-mood" => "good"]);
        } else {
            return back()->with(["msg" => "Credential already exists"]);
        }
    }

    function viewUpdateCredential(Request $r) {
        $leaders = Credential::where("credential_type", "HEAD")
            ->orWhere("credential_type", "MANGR")
            ->orWhere("credential_type", "SPRVR")->get();
        return view("admin.updatecredential")->with(["leaders" => $leaders]);
    }

    function updateCredential(Request $r) {
        $userId = $r->input("user-id");
        $userPass = $r->input("user-pass");
        $userFirst = $r->input("user-first");
        $userLast = $r->input("user-last");
        $userType = $r->input("user-type");
        $userUp = $r->input("user-up");

        $selected = Credential::where('credential_user', $userId)->first();
        if ($selected != null) {
            if ($userPass != "") $selected->setAttribute("credential_pass", $userPass);
            if ($userFirst != "") $selected->setAttribute("credential_first", $userFirst);
            if ($userLast != "") $selected->setAttribute("credential_last", $userLast);
            if ($userType != "NONE") $selected->setAttribute("credential_type", $userType);
            if ($userUp != "NONE") $selected->setAttribute("credential_up", $userUp);
            $selected->save();
            return back()->with(["msg" => "Credential updated", "msg-mood" => "good"]);
        } else {
            return back()->with(["msg" => "Credential not registered"]);
        }
    }

    function deleteCredential(Request $r) {
        $userId = $r->input("user-id");

        $selected = Credential::where('credential_user', $userId)->first();
        if ($selected != null) {
            $selected->delete();
            return back()->with(["msg" => "Credential deleted", "msg-mood" => "good"]);
        } else {
            return back()->with(["msg" => "Credential not registered"]);
        }
    }

    function viewSaveData(Request $r) {
        $supervisors = Credential::where("credential_type", "SPRVR")->get();
        return view("admin.uploaddata")->with(["supervisors" => $supervisors]);
    }

    function saveData(Request $r) {
        $year = $r->input("data-year");
        $month = $r->input("data-month");
        $team = $r->input("data-team");
        $src = $r->file("data-src");
        $ext = $src->getClientOriginalExtension();
        $filepath = $src->storeAs("data/actual/$year/$month/", $team . '.' . $ext);
        return back()->with(["msg" => "Actual data file 'public/$filepath' created", "msg-mood" => "good"]);
    }

    function viewSaveManualData(Request $r) {
        $supervisors = Credential::where("credential_type", "SPRVR")->get();
        return view("admin.uploadmanualdata")->with(["supervisors" => $supervisors]);
    }

    function saveManualData(Request $r) {
        $year = $r->input("data-year");
        $month = $r->input("data-month");
        $team = $r->input("data-team");
        $src = $r->file("data-src");
        $ext = $src->getClientOriginalExtension();
        $filepath = $src->storeAs("data/manual/$year/$month/", $team . '.' . $ext);
        return back()->with(["msg" => "Manual data file 'public/$filepath' created", "msg-mood" => "good"]);
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
        $newItem->setAttribute("score_item_class", $data["class"]);
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
}
