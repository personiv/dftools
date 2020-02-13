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
            $table->json('session_compatible_data');
            $table->string('session_notes')->default("");
            $table->boolean('session_agent_sign')->default(false);
            $table->boolean('session_supervisor_sign')->default(false);
            $table->boolean('session_manager_sign')->default(false);
            $table->boolean('session_head_sign')->default(false);
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
