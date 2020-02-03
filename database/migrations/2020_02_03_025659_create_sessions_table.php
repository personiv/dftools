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
            $table->integer('session_resource');
            $table->boolean('session_manual');
            $table->date('session_date');
            $table->string('session_notes');
            $table->boolean('session_resource_sign');
            $table->boolean('session_supervisor_sign');
            $table->boolean('session_manager_sign');
            $table->boolean('session_head_sign');
            $table->foreign('session_resource')->references('resource_id')->on('resources');
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
