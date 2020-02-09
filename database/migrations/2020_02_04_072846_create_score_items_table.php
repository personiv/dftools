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
            $table->string('score_item_class', 4);
            $table->string('score_item_name', 64);
            $table->string('score_item_desc', 1024);
            $table->string('score_item_goal', 64);
            $table->integer('score_item_weight');
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
        Schema::dropIfExists('score_items');
    }
}
