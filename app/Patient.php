<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Patient extends Authenticate
{
    use Notifiable;

    protected $guard = 'patient';
    protected $rememberTokenName = false;

    protected $fillable = [
        'nom','prenom','adresse','tel','rn', 'email', 'password','sexe','date_naiss','statut'
    ];
 
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAge(){
    	$age = Carbon::parse($this->date_naiss);

    	return $age->diffInYears(Carbon::now());
    
    }

    public function dateFormat(){

       return Carbon::parse($this->date_naiss)->format('d/m/Y');
       
    }


    public function dossierMed()
    {
        return $this->hasOne('App\DossierMed','id');
    }


    public function rdv(){
        return $this->hasMany('App\Rdv','patient_id','id');
    }


    
}
