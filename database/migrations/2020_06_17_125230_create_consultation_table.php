<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultation', function (Blueprint $table) {
            $table->Increments('id');
            $table->text('motif');
            $table->text('objectif');
            $table->text('subjectif');
            $table->text('planSuivi');
            $table->float('poids');
            $table->integer('taille');
            $table->float('pa_sys');
            $table->float('pa_dia');
            $table->float('rythme_card');
            $table->float('temperature');
            $table->integer('saturation_oxygene');
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
        Schema::dropIfExists('consultation');
    }
}
