<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FacteurRisque extends Model
{
    protected $fillable=['description','patient_id','inami_med','statut'];

    protected $table= 'facteur_risques';

    public $timestamps = true;

    public function dossierMed()
    {
        return $this->belongsTo('App\DossierMed','patient_id','patient_id');
    }
}
