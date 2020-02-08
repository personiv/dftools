<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCredentialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credentials', function (Blueprint $table) {
            $table->increments('credential_id');
            $table->string('credential_user', 24);
            $table->string('credential_pass', 24);
            $table->string('credential_type', 5);
            $table->string('credential_first', 64);
            $table->string('credential_last', 64);
            $table->string('credential_up', 24);
            $table->timestamps();
        });

        DB::table('credentials')->insert(array(
            'credential_user' => 'admin',
            'credential_pass' => 'admin',
            'credential_type' => 'ADMIN',
            'credential_first' => 'Admin',
            'credential_last' => 'Admin',
            'credential_up' => 'admin'
        ));
        DB::table('credentials')->insert(array(
            'credential_user' => '10072397',
            'credential_pass' => 'password',
            'credential_type' => 'HEAD',
            'credential_first' => 'Mike',
            'credential_last' => 'Ventanilla',
            'credential_up' => 'admin'
        ));
        DB::table('credentials')->insert(array(
            'credential_user' => '7010609',
            'credential_pass' => 'password',
            'credential_type' => 'MANGR',
            'credential_first' => 'Daryl',
            'credential_last' => 'Taguilaso',
            'credential_up' => '10072397'
        ));
        DB::table('credentials')->insert(array(
            'credential_user' => '10071937',
            'credential_pass' => 'password',
            'credential_type' => 'MANGR',
            'credential_first' => 'Ryan',
            'credential_last' => 'Pasquin',
            'credential_up' => '10072397'
        ));
        DB::table('credentials')->insert(array(
            'credential_user' => '10072003',
            'credential_pass' => 'password',
            'credential_type' => 'MANGR',
            'credential_first' => 'Carlo',
            'credential_last' => 'Mendoza',
            'credential_up' => '10072397'
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('credentials');
    }
}
