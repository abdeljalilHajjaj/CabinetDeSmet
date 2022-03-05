<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analyses', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('typeAnalyse');
            $table->string('lienFichier');
            $table->unsignedInteger('patient_id')->index();
            $table->foreign('patient_id')->references('patient_id')->on('dossierMed');
            $table->string('inami_med');
            $table->foreign('inami_med')->references('inami')->on('medecins');
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
        Schema::dropIfExists('analyses');
    }
}
