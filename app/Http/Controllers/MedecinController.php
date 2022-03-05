<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Patient;
use App\Rdv;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

class MedecinController extends Controller
{
    public function listeRdv(){
        $date = new DateTime('today');
        
        return view('medecin.medListeRdv',[
            'auj' =>$date,
        ]);
    }


    public function listPatient(){
        
       
        $patients = Patient::all();
        
        
        /*
        foreach($patients as $patient){
           if($patient->rdv->where('statut','absent')->count() > 2){
               
           }
        }
        */
        
       

        return view('medecin.listPatient',[
            'patients' => $patients,
        ]);
    }




}
