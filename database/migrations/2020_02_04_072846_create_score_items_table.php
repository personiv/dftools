<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoreItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_items', function (Blueprint $table) {
            $table->increments('score_item_id');
            $table->string('score_item_role', 8);
            $table->string('score_item_class', 64);
            $table->string('score_item_name', 64);
            $table->string('score_item_desc', 10240);
            $table->string('score_item_title', 128);
            $table->string('score_item_goal', 64);
            $table->integer('score_item_weight');
            // For dynamic data binding between system and excel files
            $table->string('score_item_cell', 8);
            // -------------------------------------------------------
            $table->timestamps();
        });

        function addItem($role, $class, $name, $desc, $title, $goal, $weight, $cell) {
            DB::table('score_items')->insert(array(
                'score_item_role' => $role,
                'score_item_class' => $class,
                'score_item_name' => $name,
                'score_item_desc' => $desc,
                'score_item_title' => $title,
                'score_item_goal' => $goal,
                'score_item_weight' => $weight,
                'score_item_cell' => $cell,
            ));
        }

        addItem("DESGN", "Quantitative Measure (95%)", "Productivity Rate", "Productivity Score (BAU, MODs, etc)", "Productivity", "10 pts per day", 25, "W");
        addItem("DESGN", "Quantitative Measure (95%)", "Quality", "Design Quality Scores (BAU) - from PR\nDesign Quality Scores (MODs) - from PR", "Quality", "80%", 10, "Y");
        addItem("DESGN", "Quantitative Measure (95%)", "Efficiency", "Design Churn", "Churn", "Refer to Tier", 25, "X");
        addItem("DESGN", "Quantitative Measure (95%)", "Efficiency", "Attendance Rate (actual score - individual)", "Attendance", "95%", 15, "AB");
        addItem("DESGN", "Quantitative Measure (95%)", "Product Knowledge", "Product Knowledge Test (actual score)", "PKT", "80%", 20, "AC");
        addItem("DESGN", "Qualitative Measure (5%)", "Bonus", "1. Admin task assignments (1st & 2nd assistants only)\n2. Commendation from the client\n3. Issue identifier (client-approved)\n4. Issue resolver (client-approved)\n5. Innovation ideas implemented on a Personiv (approved by Paulo) and/or DexYP level (approved by client).\n6. OM Initiated (core-team approved)", "Bonus", "Met 1", 5, "AF");

        addItem("WML", "Quantitative Measure (95%)", "Productivity", "BAU (1 pt per page)\nMODS (1pt per mod)\nCALLS (1pt per call)", "Productivity", "Weighted Score\nGoal: 10 points per day", 10, "W");
        addItem("WML", "Quantitative Measure (95%)", "Quality", "Design Quality Scores (BAU) - from PR\nDesign Quality Scores (MODs) - from PR", "Design Quality", "Roll-up", 10, "Y");
        addItem("WML", "Quantitative Measure (95%)", "Quality", "PSI Quality Scores (CE)", "PSI Quality", "95%", 20, "AD");
        addItem("WML", "Quantitative Measure (95%)", "FCR", "FCR", "FCR", "83%", 15, "AE");
        addItem("WML", "Quantitative Measure (95%)", "Efficiency", "Attendance Rate (actual score - individual)", "Attendance", "95.00%", 15, "AB");
        addItem("WML", "Quantitative Measure (95%)", "Efficiency", "Design Churn", "Churn", "Refer to Tier", 15, "X");
        addItem("WML", "Quantitative Measure (95%)", "Product Knowledge", "Product Knowledge Test (actual score)", "PKT", "80%", 10, "AC");
        addItem("WML", "Qualitative Measure (5%)", "Bonus", "1. Admin task assignments (1st & 2nd assistants only)\n2. Commendation from the client\n3. Issue identifier (client-approved)\n4. Issue resolver (client-approved)\n5. Innovation ideas implemented on a Personiv (approved by Paulo) and/or DexYP level (approved by client).\n6. OM Initiated (core-team approved)", "Bonus", "Met 1", 5, "AF");

        addItem("VQA", "Quantitative Measure (95%)", "Productivity", "% to Goal", "Productivity", "100.00%", 35, "W");
        addItem("VQA", "Quantitative Measure (95%)", "Quality", "TL Audit (4 audit per agent per month)", "TL Audit", "95.00%", 10, "Y");
        addItem("VQA", "Quantitative Measure (95%)", "Quality", "Disputed Audit Work", "Disputed Audit", "80.00%", 10, "AA");
        addItem("VQA", "Quantitative Measure (95%)", "Efficiency", "Attendance Rate (actual score - individual)", "Attendance", "95.00%", 15, "AB");
        addItem("VQA", "Quantitative Measure (95%)", "Product Knowledge", "External Calibration", "Calibration", "<5%", 25, "AC");
        addItem("VQA", "Qualitative Measure (5%)", "Bonus", "1. Admin task assignments (1st & 2nd assistants only)\n2. Commendation from the client\n3. Issue identifier (client-approved)\n4. Issue resolver (client-approved)\n5. Innovation ideas implemented on a Personiv (approved by Paulo) and/or DexYP level (approved by client).\n6. OM Initiated (core-team approved)", "Bonus", "Met 1", 5, "AF");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('score_items');
    }
}
