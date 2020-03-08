<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('tag_id');
            $table->string('tag_name', 8);
            $table->string('tag_type', 8);
            $table->string('tag_desc', 64);

            // If tag_multi is set to true, agent will be hidden on Create Session dialog
            // Because it contains multiple participants
            $table->boolean('tag_multi')->default(false);

            // For dynamic data binding between system and excel files
            $table->string('tag_cell', 8);
            $table->string('tag_total', 8);
            $table->string('tag_sheet', 64);
            
            $table->timestamps();
        });

        function addTag($type, $name, $desc, $multi = false, $cell = "C", $total = "AG", $sheet = "RESOURCES") {
            DB::table('tags')->insert(array(
                'tag_type' => $type,
                'tag_name' => $name,
                'tag_desc' => $desc,
                'tag_multi' => $multi,
                'tag_cell' => $cell,
                'tag_total' => $total,
                'tag_sheet' => $sheet
            ));
        }

        // Agents
        addTag("AGENT", "DESGN", "Web Designer");
        addTag("AGENT", "LEGACY", "Legacy Product Maintenance");
        addTag("AGENT", "LOGO", "Logo Designer");
        addTag("AGENT", "CUSTM", "Senior Web Designer");
        addTag("AGENT", "PR", "Website Proofreader");
        addTag("AGENT", "WML", "Web Mods Line");
        addTag("AGENT", "VQA", "Voice Quality Assurance");
        addTag("AGENT", "LGSTCS", "Logistic Executive", false, "B", "O", "Logistics Executives");
        addTag("AGENT", "DBA", "DBA");

        // Team Leaders
        addTag("LEADER", "SPRVR", "Supervisor");
        addTag("LEADER", "MANGR", "Operations Manager");
        addTag("LEADER", "HEAD", "Operations Head");

        // System Accounts
        addTag("SYSTEM", "ADMIN", "System Administrator");

        // Session Types
        // [SESSION] for supervisors
        addTag("SESSION", "SCORE", "Mid-month Scorecard");
        addTag("SESSION", "SCORE2", "Whole Month Scorecard");
        addTag("SESSION", "GOAL", "Goal Setting");
        addTag("SESSION", "COACH", "Coaching");
        addTag("SESSION", "MEET", "Meeting", true);
        // [SESSION2] for managers
        addTag("SESSION2", "TRIAD", "Triad Coaching");
        addTag("SESSION2", "MEET", "Meeting", true);
        addTag("SESSION2", "WALK", "Floorwalk", true);
        addTag("SESSION2", "BEAT", "Heartbeat", true);
        // [SESSION3] for head
        // ....
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
