<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rdv', function (Blueprint $table) {
            $table->Increments('id');
            $table->timestamp('dateRdv');
            $table->timestamp('dateFinRdv');
            $table->unsignedInteger('patient_id')->index();
            $table->foreign('patient_id')->references('id')->on('patients');
            $table->string('inami_med');
            $table->foreign('inami_med')->references('inami')->on('medecins');
            $table->string('statut');
            $table->string('gEventId');
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
        Schema::dropIfExists('rdv');
    }
}
