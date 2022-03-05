<?php

namespace App;

use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Rdv extends Model
{
    protected $fillable = ['dateRdv','dateFinRdv','patient_id','inami_med','statut','gEventId'];

    protected $table = 'rdv';

    public $timestamps = true;


    public function patient(){
        return $this->belongsTo('App\Patient','patient_id');
    }

    public function dateFormat(){

        return Carbon::parse($this->dateRdv)->format('d/m/Y H:i');
        
     }

     public function dateFinFormat(){

        return Carbon::parse($this->dateFinRdv)->format('d/m/Y H:i');
        
     }


     public function medecin(){
         return $this->belongsTo('App\Medecin','inami_med','inami');
     }


     public function unJourAvant(){
            $date = new DateTime($this->dateRdv);
            return $date->sub(new DateInterval('PT24H'));
     }

      
    
}
