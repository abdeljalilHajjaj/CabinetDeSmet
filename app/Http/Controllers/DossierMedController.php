<?php

namespace App\Http\Controllers;

use App\Antecedent;
use Illuminate\Http\Request;
use App\Patient;
use App\DossierMed;
use App\Medicament;
use App\Ordonnance;
use Illuminate\Support\Facades\Auth;

class DossierMedController extends Controller
{   
    //permets d'afficher le dossier médical d'un patient si il existe.Si il n'existe pas il est crée. 
    public function dossier($id)
    {
       
        $dossier = DossierMed::where('patient_id',$id)->first();
 
        if(empty($dossier))
        {
            $dossier = new DossierMed([
                'patient_id' => $id,
            ]);
            $dossier->save();

            return view('medecin.dossierMed',[
                'dossier'  => $dossier,
               
            ]);
        }
        if($dossier->patient->statut != 'actif'){

            return redirect('medecin/listePatient')->with('succes','Vous essayez d\'accéder à un dossier qui n\'est pas actif');

        }
        
       if($dossier){
            return view('medecin.dossierMed',[
            'dossier'  => $dossier,
            
        ]);
       }
    }





    
   
}
