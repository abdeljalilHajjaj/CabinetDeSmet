<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ordonnance extends Model
{
    protected $fillable = ['patient_id','listeMedic','lien','statut','inami_med'];

    public $timestamps = true;
    
    //inverse de la relation one to many
    public function dossierMed()
    {
        return $this->belongsTo('App\DossierMed','patient_id','patient_id');
    }

    // relation entre un médecin prescipteur et une ordonnance
    public function medecin(){
        return $this->belongsTo('App\Medecin','inami_med','inami');
    }

    //inverse de la relation one to many entre Ordonnance et Patient
    public function patient(){
        return $this->belongsTo('App\Patient','patient_id');
    }
}
