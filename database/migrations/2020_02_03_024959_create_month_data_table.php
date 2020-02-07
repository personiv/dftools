<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('month_data', function (Blueprint $table) {
            $table->increments('month_data_id');
            $table->integer('month_data_year');
            $table->string('month_data_month', 3);
            $table->string('month_data_file');
            $table->boolean('month_data_manual');
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
        Schema::dropIfExists('month_data');
    }
}
