<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DossierMed extends Model
{
    protected $fillable = ['patient_id'];

    protected $table = 'dossierMed';

    public $timestamps = true;

    //relation entre un patient et son dossier médical one to one
    public function patient()
    {
        return $this->belongsTo('App\Patient','patient_id');
    }
    //relation entre un dossier médical et ses antécédents  one to many
    public function antecedent()
    {
        return $this->hasMany('App\Antecedent','patient_id','patient_id');
    }
    //relation entre un dossier médical et ses consultation one to many
    public function consultation()
    {
        return $this->hasMany('App\Consultation','patient_id','patient_id');
    }
    //relation entre un dossier médical et ses facteur de risque one to many
    public function facteurRisque(){
        return $this->hasMany('App\FacteurRisque','patient_id','patient_id');
    }
     //relation entre un dossier médical et ses radio one to many
    public function radio()
    {
        return $this->hasMany('App\Radio','patient_id','patient_id');
    }
     //relation entre un dossier médical et ses analyse one to many
    public function analyse()
    {
        return $this->hasMany('App\Analyse','patient_id','patient_id');
    }
     //relation entre un dossier médical et ses ordonnances one to many
    public function ordonnance()
    {
        return $this->hasMany('App\Ordonnance','patient_id','patient_id');
    }
}
