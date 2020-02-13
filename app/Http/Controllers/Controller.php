<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function getProficiency($date) {
        if ($date == null) return "N/A";
        $hireDate = date_create($date);
        $dateNow = date_create(date("Y-m-d"));
        $dateDifference = date_diff($hireDate, $dateNow, true);
        $months = ((int)$dateDifference->format("%y") * 12) + (int)$dateDifference->format("%m");
        if ($months < 3) {
            return "Beginner (< 3 mos)";
        } else if ($months >= 3 && $months < 6) {
            return "Intermediate (> 3 mos)";
        } else {
            return "Experienced (> 6 mos)";
        }
    }
}
