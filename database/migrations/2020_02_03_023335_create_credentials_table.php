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
            $table->string('credential_user', 24)->unique();
            $table->string('credential_pass', 24);
            $table->string('credential_type', 5);
            $table->string('credential_first', 64);
            $table->string('credential_last', 64);
            $table->string('credential_up', 24);
            $table->date('credential_hire_date')->nullable();
            $table->string('credential_status', 16)->nullable();
            $table->timestamps();
        });

        function addEmployee($eid, $role, $first, $last, $up, $password = 'password') {
            DB::table('credentials')->insert(array(
                'credential_user' => $eid,
                'credential_pass' => $password,
                'credential_type' => $role,
                'credential_first' => $first,
                'credential_last' => $last,
                'credential_up' => $up
            ));
        }

        addEmployee('admin', 'ADMIN', 'John', 'Doe', 'admin', 'admin');
        addEmployee('10072397', 'HEAD', 'Mike', 'Ventanilla', 'admin');

        addEmployee('7010609', 'MANGR', 'Daryl', 'Taguilaso', '10072397');
            addEmployee('10071099', 'SPRVR', 'Karleen', 'Cedeno', '7010609');
                

            addEmployee('10071309', 'SPRVR', 'Noel', 'Cruz', '7010609');
                addEmployee('10072198', 'DESGN', 'Edwin', 'Allingag', '10071309');
                addEmployee('10072438', 'DESGN', 'Jerome', 'Arcabos', '10071309');
                addEmployee('10072244', 'DESGN', 'Jinky', 'Cantal', '10071309');
                addEmployee('10072444', 'DESGN', 'Justin Ivan', 'Dizon', '10071309');
                addEmployee('10072449', 'DESGN', 'Jack Thomson', 'Guden', '10071309');
                addEmployee('10071728', 'DESGN', 'Kim Lawrenze', 'Lumaban', '10071309');
                addEmployee('10071592', 'DESGN', 'Angelica', 'Macalalad', '10071309');
                addEmployee('10071306', 'DESGN', 'Jean Erika', 'Macorol', '10071309');
                addEmployee('10072228', 'DESGN', 'Anica Jahna', 'Malimban', '10071309');
                addEmployee('10071692', 'DESGN', 'Paul Alexius', 'Manalo', '10071309');
                addEmployee('10072517', 'DESGN', 'Kristian Jay', 'Maniclang', '10071309');
                addEmployee('10072204', 'DESGN', 'Jayveneil', 'Monterey', '10071309');
                addEmployee('10072180', 'DESGN', 'Christian Mari', 'Roque', '10071309');
                addEmployee('10072073', 'DESGN', 'John Anthony', 'Rosete', '10071309');
                addEmployee('10072445', 'DESGN', 'Marijun', 'Villareal', '10071309');
                
            addEmployee('10072501', 'SPRVR', 'Richard', 'De Los Santos', '7010609');

        addEmployee('10071937', 'MANGR', 'Ryan', 'Pasquin', '10072397');
            // WML here
            addEmployee('10071245', 'SPRVR', 'Reymark', 'Regencia', '10071937');
            addEmployee('10071256', 'SPRVR', 'Renell', 'Barrios', '10071937');
                addEmployee('10071908', 'WML', 'Marimar', 'Domingo', '10071256');
                addEmployee('10071600', 'WML', 'Lizbert', 'Ortillano', '10071256');
                addEmployee('10072220', 'WML', 'Marlon', 'Magpoc', '10071256');

            // VQA here 
            addEmployee('10071492', 'SPRVR', 'Katherine', 'Arpon', '10071937');
                addEmployee('10072613', 'VQA', 'Francis', 'Rempillo', '10071492');
                addEmployee('10072011', 'VQA', 'Hannah Elkanah', 'Santos', '10071492');
                addEmployee('10072010', 'VQA', 'Julie Ann', 'Torres', '10071492');

            // Proofer here
            addEmployee('10070828', 'SPRVR', 'Apple', 'Remulla', '10071937');
                addEmployee('10072182', 'PR', 'Ayra', 'Gonzaga', '10070828');
                addEmployee('10072472', 'PR', 'Angelica', 'Liad', '10070828');
                addEmployee('10072069', 'PR', 'Pauline Joyce', 'Monzon', '10070828');
            

        addEmployee('10072003', 'MANGR', 'Carlo', 'Mendoza', '10072397');
            addEmployee('10070715', 'SPRVR', 'Franklin', 'Jayawon', '10072003');
            addEmployee('10072502', 'SPRVR', 'Mark Anthony', 'Lapastora', '10072003');
            addEmployee('10072072', 'SPRVR', 'Emmanuel', 'Flores', '10072003');
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
