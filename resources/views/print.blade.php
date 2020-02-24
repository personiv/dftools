<?php
    $user = session("user");
    $agent = $session->Agent();
    $data = $session->Data();
    $scorecard = $data["scorecard"] ?? [];
    $scorecardGoal = $data["scorecardGoal"] ?? [];
    $fields = $data["fields"] ?? [];
    $signees = $data["signatures"] ?? [];
?>

Print Area Here....