<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Disponibilite extends Model
{
    protected $fillable = ['inami_med','details','dateDebut','dateFin','gEventId','statut'];


    public $timestamps = true;

    public function medecin(){
        return $this->belongsTo('App\Medecin','inami_med','inami');

    }


    public function dateFormat(){

        return Carbon::parse($this->dateDebut)->format('d/m/Y H:i');
        
     }

     public function dateFinFormat(){

        return Carbon::parse($this->dateFin)->format('d/m/Y H:i');
        
     }

}
