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
            $table->string('score_item_role', 5);
            $table->string('score_item_class', 64);
            $table->string('score_item_name', 64);
            $table->string('score_item_desc', 1024);
            $table->string('score_item_goal', 64);
            $table->integer('score_item_weight');
            $table->timestamps();
        });

        function addItem($role, $class, $name, $desc, $goal, $weight) {
            DB::table('score_items')->insert(array(
                'score_item_role' => $role,
                'score_item_class' => $class,
                'score_item_name' => $name,
                'score_item_desc' => $desc,
                'score_item_goal' => $goal,
                'score_item_weight' => $weight
            ));
        }

        addItem("DESGN", "Quantitative Measure (95%)", "Productivity Rate", "Productivity Score (BAU, MODs, etc)", "10 pts per day", 25);
        addItem("DESGN", "Quantitative Measure (95%)", "Quality", "Design Quality Scores (BAU) - from PR\nDesign Quality Scores (MODs) - from PR", "80%", 10);
        addItem("DESGN", "Quantitative Measure (95%)", "Efficiency", "Design Churn", "Refer to Tier", 25);
        addItem("DESGN", "Quantitative Measure (95%)", "Efficiency", "Attendance Rate (actual score - individual)", "95%", 15);
        addItem("DESGN", "Quantitative Measure (95%)", "Product Knowledge", "Product Knowledge Test (actual score)", "80%", 20);
        addItem("DESGN", "Qualitative Measure (5%)", "Bonus", "1. Admin task assignments (1st & 2nd assistants only)\n2. Commendation from the client\n3. Issue identifier (client-approved)\n4. Issue resolver (client-approved)\n5. Innovation ideas implemented on a Personiv (approved by Paulo) and/or DexYP level (approved by client).\n6. OM Initiated (core-team approved)", "Met 1", 5);
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
