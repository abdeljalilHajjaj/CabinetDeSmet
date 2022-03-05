<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analyse extends Model
{
    protected $fillable = ['patient_id','typeAnalyse','lienFichier','inami_med','statut'];

    public $timestamps = true;
    
    public function dossierMed()
    {
        return $this->belongsTo('App\DossierMed','patient_id','patient_id');
    }
}
