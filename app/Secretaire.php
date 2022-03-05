<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Model;

class Secretaire extends Authenticate
{
    use Notifiable;

    protected $guard = 'secretaire';

    protected $fillable = [
        'nom','prenom', 'email', 'password','adresse','tel','statut'
    ];
 
    protected $hidden = [
        'password'
    ];
}
