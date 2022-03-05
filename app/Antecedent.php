<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antecedent extends Model
{
    protected $fillable = ['patient_id','description','inami_med','statut'];

    public $timestamps = true;

    protected $table = 'antecedents';


    public function dossierMed()
    {
        return $this->belongsTo('App\DossierMed','patient_id','patient_id');
    }
}
