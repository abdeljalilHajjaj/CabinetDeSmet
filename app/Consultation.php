<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = ['patient_id','motif','objectif','subjectif','planSuivi','temperature','poids','taille','pa_sys','pa_dia','rythme_card','saturation_oxygene','statut','inami_med'];

    public $timestamps = true;

    protected $table = 'consultation';


    public function dossierMed()
    {
        return $this->belongsTo('App\DossierMed','patient_id','patient_id');
    }
}
