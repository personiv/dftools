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
            $table->timestamps();
        });

        function addTag($type, $name, $desc) {
            DB::table('tags')->insert(array(
                'tag_type' => $type,
                'tag_name' => $name,
                'tag_desc' => $desc
            ));
        }

        // Agents
        addTag("AGENT", "DESGN", "Web Designer");
        addTag("AGENT", "CUSTM", "Senior Web Designer");
        addTag("AGENT", "PR", "Website Proofreader");
        addTag("AGENT", "WML", "Web Mods Line");
        addTag("AGENT", "VQA", "Voice Quality Assurance");

        // Team Leaders
        addTag("LEADER", "SPRVR", "Supervisor");
        addTag("LEADER", "MANGR", "Operation Manager");
        addTag("LEADER", "HEAD", "Operation Head");

        // Session Types
        addTag("SESSION", "SCORE", "Scorecard");
        addTag("SESSION", "GOAL", "Goal Setting");
        addTag("SESSION", "COACH", "Coaching");
        addTag("SESSION", "TRIAD", "Triad Coaching");
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
