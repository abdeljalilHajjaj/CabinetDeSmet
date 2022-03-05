<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmationInscription;
use App\Mail\Inscription;
use Illuminate\Http\Request;
use App\Patient;
use Illuminate\Queue\Jobs\RedisJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class PatientController extends Controller
{
    //affiche la page qui permets à un patient de modifier ses données personnelles
    public function index()
    {
        return view('patient.modifProfil');
    }
    //modifie les données personnelles d'un patient et enregistre les modifications en db
    public function update(Request $request)
    {
        $request->validate([
            'adresse' => 'required|string|max:255',
            'tel' => 'required|digits:10',
        ]);

        $patient = Patient::find($request->id);
        
        $patient->adresse = $request->get('adresse');
        $patient->tel =  $request->get('tel');
        $patient->save();
        return redirect()->route('Profil');
    }
    //affiche le formulaire d'ajout d'un patient pour une secrétaire
    public function viewAjouterPat(){

        return view('secretaire.secPatient.ajouterPatient');
        
    }

    //crée une instance de la classe Patient et enregistre l'objet en base de données
    public function secAjouterPat(Request $request){

        $data = $request->validate([

        'rn' => ['required','digits:11','unique:patients'],
        'tel' => ['required','digits:10'],
        'name' => ['required', 'string', 'max:255'],
        'date_naiss' => ['required'],
        'sexe' => ['required'],
        'prenom' => ['required', 'string', 'max:255'],
        'adresse' => ['required', 'string', 'max:255'],
        
    ],
     [   'rn.unique' => 'Le numéro de registre national existe déjà dans notre base de données',
         'rn.digits' => 'Le numéro de registre national doit contenir 11 chiffres',
         'rn.required' =>'Le champ numéro de registre national ne peut être vide',
     ]);

     $patient = Patient::create([
        'rn' =>$data['rn'],
        'tel' =>$data['tel'],
        'nom' => $data['name'],
        'prenom' => $data['prenom'],
        'date_naiss' =>$data['date_naiss'],
        'sexe' => $data['sexe'],
        'adresse' => $data['adresse'],
        'statut' => 'en attente',
    ]);
    
    return redirect()->route('sec.index')->with('succes','Le patient a bien été crée');


    }

    //affiche la liste des patients pour une secrétaire
    public function secListePatient(){
        
       
        $patients = Patient::all();
        
        return view('secretaire.secPatient.listePatient',[
            'patients' => $patients,
        ]);
    }
    //affiche une liste des patients dont l'inscription n'est pas finalisée
    public function listePatientAttente(){
        
       
        $patients = Patient::where('statut','en attente')->get();

        
        return view('secretaire.secPatient.listeAttentePatient',[
            'patients' => $patients,
        ]);
    }

    //envoie une mail de confirmation pour l'inscription et modifie le statut du patient.
    public function confirmerInscription($id){

        $patient = Patient::find($id);

        $patient->statut = 'actif';

        $patient->save();

        $data = array('nom'=>$patient->nom,'prenom'=>$patient->prenom,'rn'=>$patient->rn,'sexe'=>$patient->sexe);
        if($patient->email){
            Mail::to($patient->email)->send(new ConfirmationInscription($data));
        }
       
        return back()->with('succes','La tâche a été effectué avec succes');
    }




    
}
