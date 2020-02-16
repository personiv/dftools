<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->increments('session_id');
            $table->string('session_type', 5);
            $table->string('session_agent', 24);
            $table->string('session_mode', 6);
            $table->integer('session_year');
            $table->string('session_month', 4);
            $table->integer('session_day');
            $table->integer('session_week');
            // Add dynamic data in session_data
            // Including signees, notes, commitment, strengths, scorecard items, scorecard actual scores, etc.
            $table->json('session_data');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
