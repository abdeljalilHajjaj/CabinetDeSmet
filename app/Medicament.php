<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    protected $fillable = ['nomMedic','codeMedic','posologie','statut'];

    public $timestamps = true;


    
}
