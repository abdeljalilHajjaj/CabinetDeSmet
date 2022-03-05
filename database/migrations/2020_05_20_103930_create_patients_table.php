<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nom')->lenght(60);
            $table->string('prenom')->lenght(60);
            $table->string('adresse');
            $table->string('tel');
            $table->string('sexe');
            $table->date('date_naiss');
            $table->string('rn')->lenght(11)->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('statut');
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
        Schema::dropIfExists('patients');
    }
}
