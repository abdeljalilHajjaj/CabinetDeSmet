<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Model;

class Medecin extends Authenticate
{
    use Notifiable;

    protected $guard = 'medecin';

    protected $fillable = [
        'nom', 'email', 'password','adresse','tel','inami','statut'
    ];
 
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $timestamps = true;


    public function rdv(){
        return $this->hasMany('App\Rdv','inami_med','inami');
    }


    public function disponibilite(){

        return $this->hasMany('App\Disponibilite','inami_med','inami');
    }
}
