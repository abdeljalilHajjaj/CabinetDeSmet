<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Radio extends Model
{
    protected $fillable = ['patient_id','details','lien','','statut','inami_med'];

    public $timestamps = true;

    protected $table = 'radios';


    public function dossierMed()
    {
        return $this->belongsTo('App\DossierMed','patient_id','patient_id');
    }
}
