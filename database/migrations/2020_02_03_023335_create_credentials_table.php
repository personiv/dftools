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
            $table->string('credential_type', 8);
            $table->string('credential_first', 64);
            $table->string('credential_last', 64);
            $table->string('credential_up', 24);
            $table->longText('credential_img')->default('images/john_doe.jpg');
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

        // Admin
        addEmployee('admin', 'ADMIN', 'John', 'Doe', 'admin', 'admin');



        /*
        // Tower Mike —————
        */
        addEmployee('10072397', 'HEAD', 'Mike', 'Ventanilla', 'admin');



        /*
        // Cluster Carlo here —————
        */
        addEmployee('10072003', 'MANGR', 'Carlo', 'Mendoza', '10072397');

            // Team Frank / Designer
            addEmployee('10070715', 'SPRVR', 'Franklin', 'Jayawon', '10072003');
                addEmployee('10072155', 'DESGN', 'Mark Christian', 'Balintong', '10070715');
                addEmployee('10072158', 'DESGN', 'Diana Rose', 'Constantino', '10070715');
                addEmployee('10072451', 'DESGN', 'Sharmaine', 'Diaz', '10070715');
                addEmployee('10071594', 'DESGN', 'Francismel', 'Dictado', '10070715');
                addEmployee('10072241', 'DESGN', 'Encinas', 'Aaron', '10070715');
                addEmployee('10072237', 'DESGN', 'Kier', 'Latayan', '10070715');
                addEmployee('10072249', 'LEGACY', 'Shermin Joy', 'Mamolo', '10070715');
                addEmployee('10071067', 'DESGN', 'Jerwin', 'Munoz', '10070715');
                addEmployee('10071420', 'DESGN', 'Angelica', 'Nielo', '10070715');
                addEmployee('10071677', 'DESGN', 'Cyrus Ian', 'Pascual', '10070715');
                addEmployee('10071253', 'CUSTM', 'Alvin', 'Prado', '10070715');
                addEmployee('10072255', 'DESGN', 'Renzel', 'Remulla', '10070715');
                addEmployee('10070729', 'CUSTM', 'Romniel', 'Salumbides', '10070715');
                addEmployee('10072450', 'DESGN', 'Almar Abraham', 'Santiago', '10070715');
                addEmployee('10072440', 'LOGO', 'Emmanuel', 'Tigley', '10070715');

            // Team Mark / Designer
            addEmployee('10072502', 'SPRVR', 'Mark Anthony', 'Lapastora', '10072003');
                addEmployee('10072201', 'DESGN', 'Paul Christian', 'Argao', '10072502');
                addEmployee('10071631', 'DESGN', 'Rhyalyn', 'Aseron', '10072502');
                addEmployee('10072179', 'DESGN', 'Riiza Mei', 'Belesina', '10072502');
                addEmployee('10072157', 'DESGN', 'Kim Bryan', 'Blancaflor', '10072502');
                addEmployee('10071958', 'DESGN', 'Mark Anthony', 'Canayon', '10072502');
                addEmployee('10071899', 'DESGN', 'Ma. Bettina', 'Cruz', '10072502');
                addEmployee('10071039', 'CUSTM', 'Daryl Angelo', 'Estrella', '10072502');
                addEmployee('10071261', 'DESGN', 'Dionel', 'Gales', '10072502');
                addEmployee('10071751', 'DESGN', 'Gerald John', 'Gales', '10072502');
                addEmployee('10072238', 'DESGN', 'Mharvic', 'Inocentes', '10072502');
                addEmployee('10072026', 'DESGN', 'Dianne Grace', 'Lat', '10072502');
                addEmployee('10071275', 'DESGN', 'Noriel Bernard', 'Lugo', '10072502');
                addEmployee('10072233', 'DESGN', 'Rickzel', 'Paderagao', '10072502');
                addEmployee('10072159', 'DESGN', 'Renz', 'Salazar', '10072502');
                addEmployee('10072105', 'DESGN', 'Daryl', 'Villabriga', '10072502');

            // Team Emman / Designer
            addEmployee('10072072', 'SPRVR', 'Emmanuel', 'Flores', '10072003');
                addEmployee('10071358', 'DESGN', 'Eloisa', 'Batayon', '10072072');
                addEmployee('10071910', 'DESGN', 'Shaira', 'Beltran', '10072072');
                addEmployee('10071803', 'DESGN', 'Paulo', 'Bragado', '10072072');
                addEmployee('10071433', 'DESGN', 'Rolando', 'Caraig Jr.', '10072072');
                addEmployee('10072437', 'DESGN', 'Rowel', 'Cruz', '10072072');
                addEmployee('10072177', 'DESGN', 'Ed Joshua', 'Diaz', '10072072');
                addEmployee('10072063', 'DESGN', 'Booz Joshua', 'Faburada', '10072072');
                addEmployee('10072076', 'DESGN', 'Elmer', 'Fernandez', '10072072');
                addEmployee('10072453', 'DESGN', 'Rhea', 'Honrado', '10072072');
                addEmployee('10071753', 'DESGN', 'Arjiel', 'Maroto', '10072072');
                addEmployee('10071603', 'DBA', 'Roseann', 'Mercado', '10072072');
                addEmployee('10071268', 'DESGN', 'Pauline Sienne', 'Ocenar', '10072072');
                addEmployee('10071296', 'DESGN', 'Allan', 'Rodriguez', '10072072');
                addEmployee('10071972', 'DBA', 'Daniell Erik', 'Salamante', '10072072');
                addEmployee('10071283', 'DESGN', 'Patrice Anne', 'Sestoso', '10072072');
                addEmployee('10070976', 'DESGN', 'Nesser Carlo', 'Trinidad', '10072072');

        
        /*
        // Cluster Daryl here —————
        */
        addEmployee('7010609', 'MANGR', 'Daryl', 'Taguilaso', '10072397');

            // Team Karleen / Designer
            addEmployee('10071099', 'SPRVR', 'Karleen', 'Cedeno', '7010609');
                addEmployee('10072460', 'DESGN', 'Aira Regina', 'Dela Cruz', '10071099');
                addEmployee('10071423', 'DESGN', 'Vernard', 'Delos Reyes', '10071099');
                addEmployee('10071301', 'DESGN', 'Nomar', 'Esguerra', '10071099');
                addEmployee('10071775', 'DESGN', 'John Gabriel', 'Fabicon', '10071099');
                addEmployee('10072031', 'DESGN', 'Carl Anthony', 'Galang', '10071099');
                addEmployee('10072245', 'DESGN', 'Dyan Jay', 'Gorospe', '10071099');
                addEmployee('10072160', 'DESGN', 'Adrian', 'Lagaya', '10071099');
                addEmployee('10071252', 'DESGN', 'Jennyfer', 'Mercado', '10071099');
                addEmployee('10071147', 'DESGN', 'Jerome', 'Morada', '10071099');
                addEmployee('10072457', 'DESGN', 'Ezekiel', 'Napalang', '10071099');
                addEmployee('10070728', 'DESGN', 'Mary Ruth Suzaine', 'Obispo', '10071099');
                addEmployee('10071310', 'DESGN', 'Ma. Ann Jelette', 'Paredes', '10071099');
                addEmployee('10072515', 'DESGN', 'Kristian Dave', 'Pelegrino', '10071099');
                addEmployee('10072211', 'DESGN', 'Jedalyn', 'Ranera', '10071099');
                addEmployee('10071903', 'DESGN', 'Rose Ann', 'Sumalinog', '10071099');

            // Team Noel / Designer
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
                
            // Team Chado / Designer
            addEmployee('10072501', 'SPRVR', 'Richard', 'De Los Santos', '7010609');
                addEmployee('10072458', 'DESGN', 'Apolinario', 'Bacurin Jr.', '10072501');
                addEmployee('10071188', 'DESGN', 'John Benneth', 'Cabauatan', '10072501');
                addEmployee('10071322', 'LOGO', 'Monneyr Jhon', 'De Guzman', '10072501');
                addEmployee('10071429', 'LEGACY', 'Paul Andrew', 'Dedel', '10072501');
                addEmployee('10071430', 'DESGN', 'Amiel Jaeso', 'Enriquez', '10072501');
                addEmployee('10072202', 'CUSTM', 'Marc Ranielle', 'Garcia', '10072501');
                addEmployee('10072205', 'DESGN', 'Shaira Mae', 'Hernaez', '10072501');
                addEmployee('10072256', 'DESGN', 'Lansigan', 'Ericka', '10072501');
                addEmployee('10071432', 'CUSTM', 'Jan', 'Lardizabal', '10072501');
                addEmployee('10072516', 'DESGN', 'Lycel', 'Martinez', '10072501');
                addEmployee('10072206', 'DESGN', 'Jomar', 'Rabanera', '10072501');
                addEmployee('10072243', 'CUSTM', 'John Archer', 'Saulon', '10072501');
                addEmployee('10072096', 'DESGN', 'Dean Felix', 'Talania', '10072501');



        /*
        // Cluster Ryan here —————
        */
        addEmployee('10071937', 'MANGR', 'Ryan', 'Pasquin', '10072397');

            // Team Butch / WML
            addEmployee('10071245', 'SPRVR', 'Reymark', 'Regencia', '10071937');
                addEmployee('10072156', 'WML', 'Nichole Jan', 'Anastacio', '10071245');
                addEmployee('10072301', 'WML', 'Luke Arvin', 'Arceo', '10071245');
                addEmployee('10071904', 'WML', 'Shaira Mae', 'Borela', '10071245');
                addEmployee('10071278', 'WML', 'Jessna Marie', 'De Leon', '10071245');
                addEmployee('10072207', 'WML', 'Shiela Marie', 'Diaz', '10071245');
                addEmployee('10071198', 'WML', 'Marichris', 'Dikit', '10071245');
                addEmployee('10072040', 'WML', 'Raymond', 'Fernandez', '10071245');
                addEmployee('10071199', 'WML', 'Renzy Elaine', 'Gonzales', '10071245');
                addEmployee('10072452', 'WML', 'Michael Dominic', 'Pelagio', '10071245');
                addEmployee('10071178', 'WML', 'Erwin Reiner', 'Pelayo', '10071245');
                addEmployee('10071439', 'WML', 'Stephanie', 'Pimentel', '10071245');
                addEmployee('10071314', 'WML', 'Sheena', 'Torres', '10071245');

            // Team Renell / WML
            addEmployee('10071256', 'SPRVR', 'Renell', 'Barrios', '10071937');
                addEmployee('10071356', 'WML', 'Emmalyn', 'Aranas', '10071256');
                addEmployee('10072224', 'WML', 'Jayson', 'Buna', '10071256');
                addEmployee('10072032', 'WML', 'Eldon', 'Dela Paz', '10071256');
                addEmployee('10071908', 'WML', 'Marimar', 'Domingo', '10071256');
                addEmployee('10071411', 'WML', 'Jade', 'Encinares', '10071256');
                addEmployee('10072220', 'WML', 'Marlon', 'Magpoc', '10071256');
                addEmployee('10071342', 'WML', 'John Nico', 'Molon', '10071256');
                addEmployee('10071946', 'WML', 'Harty Jones', 'Narciso', '10071256');
                addEmployee('10071600', 'WML', 'Lizbert', 'Ortillano', '10071256');
                addEmployee('10071729', 'WML', 'Rhiyana Venise', 'Padua', '10071256');
                addEmployee('10071151', 'WML', 'Darren', 'Rabe', '10071256');
                addEmployee('10072439', 'WML', 'Mariann', 'Sandoval', '10071256');

            // Team Kath / VQA
            addEmployee('10071492', 'SPRVR', 'Katherine', 'Arpon', '10071937');
                addEmployee('10071047', 'VQA', 'Michelle', 'Anova', '10071492');
                addEmployee('10072592', 'VQA', 'Annalyn', 'De Luna', '10071492');
                addEmployee('10071902', 'VQA', 'Jordan', 'Diaz', '10071492');
                addEmployee('10071190', 'VQA', 'Mary Jane', 'Glory', '10071492');
                addEmployee('10072441', 'VQA', 'Ken Andrei', 'Mendoza', '10071492');
                addEmployee('10072604', 'VQA', 'Ranier Allan', 'Moldes', '10071492');
                addEmployee('10072203', 'VQA', 'Joeseph Deinniel', 'Pariñas', '10071492');
                addEmployee('10072613', 'VQA', 'Francis', 'Rempillo', '10071492');
                addEmployee('10072011', 'VQA', 'Hannah Elkanah', 'Santos', '10071492');
                addEmployee('10072010', 'VQA', 'Julie Ann', 'Torres', '10071492');

            // Team Apple / Proofer
            addEmployee('10070828', 'SPRVR', 'Apple', 'Remulla', '10071937');
                addEmployee('10071071', 'PR', 'Katrina', 'Amon', '10070828');   
                addEmployee('10072471', 'PR', 'Geraldine', 'Condes', '10070828');
                addEmployee('10072182', 'PR', 'Ayra', 'Gonzaga', '10070828');
                addEmployee('10072222', 'PR', 'Jose Armando', 'Gutierrez II', '10070828');
                addEmployee('10072472', 'PR', 'Angelica', 'Liad', '10070828');
                addEmployee('10072069', 'PR', 'Pauline Joyce', 'Monzon', '10070828');
                addEmployee('10072097', 'PR', 'Mary Grace', 'Naval', '10070828');
                addEmployee('10071617', 'PR', 'Cristina May', 'Parrilla', '10070828');
                addEmployee('10072213', 'PR', 'Mary Carl Dorotea', 'Ralleca', '10070828');
                addEmployee('10071055', 'PR', 'Dante', 'Suarez', '10070828');
                addEmployee('10070996', 'PR', 'Sean', 'Surbona', '10070828');
                addEmployee('10071355', 'PR', 'Erise', 'Teodosio', '10070828');
                addEmployee('10072007', 'PR', 'Irand Alyssa', 'Tomo', '10070828');
                addEmployee('10072184', 'PR', 'Winnie', 'Vargas', '10070828');
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     **/
    public function down()
    {
        Schema::dropIfExists('credentials');
    }
}
