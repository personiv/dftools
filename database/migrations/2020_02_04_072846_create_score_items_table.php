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
                'score_item_cell' => $cell
            ));
        }

        function addBonus($role, $cell = "AF") {
            addItem($role, "Qualitative Measure (5%)",
                "Bonus",
                "", "Bonus",
                "Met 1",
                5, $cell);
        }

        // Web Designer
        addItem("DESGN", "Quantitative Measure (95%)",
            "Productivity Rate",
            "Productivity Score (BAU, MODs, etc)",
            "Productivity",
            "10 points",
            25, "W");
            
        addItem("DESGN", "Quantitative Measure (95%)",
            "Quality",
            "Design Quality Scores (BAU) - from PR\nDesign Quality Scores (MODs) - from PR",
            "Quality",
            "Roll-up",
            10, "Y");

        addItem("DESGN", "Quantitative Measure (95%)",
            "Efficiency",
            "Design Churn",
            "Churn",
            "Refer to Tier",
            25, "X");

        addItem("DESGN", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95%",
            15, "AB");

        addItem("DESGN", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "PKT",
            "80%",
            20, "AC");

        addBonus("DESGN");

        // Legacy Product Maintenance
        addItem("LEGACY", "Quantitative Measure (95%)",
            "Productivity Rate (actual score)",
            "BAU - Mobile Display (4 pts per task)\nMODS - Mobile Display (1pt per mod)\nWeb Design BAU (1 point per page)\nWeb Design MODs (1 point per MOD)\nBAU  - YP Banner (.25pt per task)\nMODS - YP Banner (.25pt per task)\nWeb Design BAU (1 point per page)\nWeb Design MODs (1 point per MOD)",
            "Productivity",
            "Weighted Score\n(10 pts per day)",
            30, "W");

        addItem("LEGACY", "Quantitative Measure (95%)",
            "Quality",
            "BAU - Mobile Display / YP Banner (60%)\nMODS - Mobile Display / YP Banner (40%)",
            "MD/YPB Quality",
            "Roll-up",
            5, "Y");

        addItem("LEGACY", "Quantitative Measure (95%)",
            "Quality",
            "Web Design BAU (60%)\nWeb Design MODS (40%)",
            "Design Quality",
            "Roll-up",
            5, "Y");

        addItem("LEGACY", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95%",
            15, "AB");

        addItem("LEGACY", "Quantitative Measure (95%)",
            "Efficiency",
            "Design Churn",
            "Churn",
            "Refer to Tier",
            20, "X");

        addItem("LEGACY", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "PKT",
            "80%",
            20, "AC");

        addBonus("LEGACY");

        // Website Proofreader
        addItem("PR", "Quantitative Measure (95%)",
            "Productivity Rate",
            "BAU (1 pt per BAU)\nMODS (0.40 pts per mod)",
            "Productivity",
            "Weighted Score\n(6 pts per day)",
            34, "W");

        addItem("PR", "Quantitative Measure (95%)",
            "Quality",
            "Quality Score\nCompuated as  = 100%-Defect Rate\nDefect Rate = Valid disputes / Count of QC Reject",
            "Quality",
            "Rollup Score",
            26, "Y");

        addItem("PR", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95%",
            15, "AB");

        addItem("PR", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "PKT",
            "80%",
            10, "AC");

        addItem("PR", "Quantitative Measure (95%)",
            "Product Knowledge",
            "PR Calibration (tiering score)",
            "Calibration",
            "80%",
            10, "Z");

        addBonus("PR");

        // Logo Designer
        addItem("LOGO", "Quantitative Measure (95%)",
            "Productivity Rate",
            "BAU (1pt per page)\nMODS (1pt per mods)\nLogo Task (5pt per logo)",
            "Productivity",
            "Weighted Score\n(10 pts per day)",
            30, "W");

        addItem("LOGO", "Quantitative Measure (95%)",
            "Quality",
            "Logo Quality",
            "Logo Quality",
            "Roll-up Score",
            5, "Y");

        addItem("LOGO", "Quantitative Measure (95%)",
            "Quality",
            "Web Design BAU (60%)\nWeb Design MODS (40%)",
            "Design Quality",
            "Roll-up Score",
            5, "Y");

        addItem("LOGO", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95.00%",
            15, "AB");

        addItem("LOGO", "Quantitative Measure (95%)",
            "Efficiency",
            "Design Churn",
            "Churn",
            "Refer to Tier",
            20, "X");

        addItem("LOGO", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "PKT",
            "80.00%",
            20, "AC");

        addBonus("LOGO");
        
        // Custom Web Designer
        addItem("CUSTM", "Quantitative Measure (95%)",
            "Productivity Rate (actual)",
            "BAU (4pts per page)\nMODS (5pts per mods)",
            "Productivity",
            "Weighted Score\n(10 pts per day)",
            30, "W");

        addItem("CUSTM", "Quantitative Measure (95%)",
            "Quality (PR generated)",
            "BAU (60%)\nMODS (40%)",
            "Quality",
            "Roll-up",
            10, "Y");

        addItem("CUSTM", "Quantitative Measure (95%)",
            "Efficiency",
            "Design Churn",
            "Design Churn",
            "Refer to Tier",
            20, "X");

        addItem("CUSTM", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95.00%",
            15, "AB");

        addItem("CUSTM", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "PKT",
            "80.00%",
            20, "AC");

        addBonus("CUSTM");
        
        // Logistic Executive
        addItem("LGSTCS", "Quantitative Measure (95%)",
            "Effectiveness",
            "Scorecard Roll-Up (site wide)",
            "Effectiveness",
            "Roll-up",
            50, "K");

        addItem("LGSTCS", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95.00%",
            30, "L");
        
        addItem("LGSTCS", "Quantitative Measure (95%)",
            "Client Escalations",
            "Escalation from Clients - external & internal (reaching Mike V,  DG and Paulo and clients)",
            "Escalations",
            "< 2",
            15, "M");
        
        addBonus("LGSTCS", "N");

        // Web Mods Line
        addItem("WML", "Quantitative Measure (95%)",
            "Productivity",
            "BAU (1 pt per page)\nMODS (1pt per mod)\nCALLS (1pt per call)",
            "Productivity",
            "Weighted Score\nGoal: 10 points per day",
            10, "W");

        addItem("WML", "Quantitative Measure (95%)",
            "Quality",
            "Design Quality Scores (BAU) - from PR\nDesign Quality Scores (MODs) - from PR",
            "Design Quality",
            "Roll-up",
            10, "Y");

        addItem("WML", "Quantitative Measure (95%)",
            "Quality",
            "PSI Quality Scores (CE)",
            "PSI Quality",
            "95%",
            20, "AD");

        addItem("WML", "Quantitative Measure (95%)",
            "FCR",
            "FCR",
            "FCR",
            "83%",
            15, "AE");

        addItem("WML", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)",
            "Attendance",
            "95.00%",
            15, "AB");

        addItem("WML", "Quantitative Measure (95%)",
            "Efficiency",
            "Design Churn",
            "Churn",
            "Refer to Tier",
            15, "X");

        addItem("WML", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "PKT",
            "80%",
            10, "AC");

        addBonus("WML");

        // Voice Quality Assurance
        addItem("VQA", "Quantitative Measure (95%)",
            "Productivity",
            "% to Goal",
            "Productivity",
            "100.00%",
            35, "W");

        addItem("VQA", "Quantitative Measure (95%)",
            "Quality",
            "TL Audit (4 audit per agent per month)",
            "TL Audit",
            "95.00%",
            10, "Y");

        addItem("VQA", "Quantitative Measure (95%)",
            "Quality",
            "Disputed Audit Work",
            "Disputed Audit",
            "80.00%",
            10, "AA");

        addItem("VQA", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)", "Attendance",
            "95.00%",
            15, "AB");

        addItem("VQA", "Quantitative Measure (95%)",
            "Product Knowledge",
            "External Calibration",
            "Calibration",
            "<5%",
            25, "AC");

        addBonus("VQA");

        // DBA
        addItem("DBA", "Quantitative Measure (95%)",
            "Productivity",
            "DBA (1.75 points per task)",
            "Productivity",
            "Weighted Score\nGoal: 10 points per day",
            40, "W");

        addItem("DBA", "Quantitative Measure (95%)",
            "Quality",
            "SMRA Quality results",
            "Quality",
            "Refer to Tier",
            10, "Y");

        addItem("VQA", "Quantitative Measure (95%)",
            "Efficiency",
            "Attendance Rate (actual score - individual)", "Attendance",
            "95.00%",
            20, "AB");

        addItem("DBA", "Quantitative Measure (95%)",
            "Product Knowledge",
            "Product Knowledge Test (actual score)",
            "Calibration",
            "80%",
            25, "AC");
        
        addBonus("DBA");
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
