<?php

namespace App\Http\Controllers;

use App\Medecin;
use App\Patient;
use App\Rdv;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Response;

class RdvController extends Controller
{
    //permets de créer un client google reutilisable dans toute la classe RdvController
    public function __construct()
    {
        $client = new Google_Client();
        $client->setAuthConfig('client_secret.json');
        $client->addScope(Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');
        $client->setIncludeGrantedScopes(true);

        $guzzleClient = new \GuzzleHttp\Client(array('verify'=>false,'curl' => array(CURLOPT_SSL_VERIFYPEER => 0)));
        $client->setHttpClient($guzzleClient);
        $this->client = $client;
    }

    //retourne la liste des rendez-vous d'un patient
    public function index()
    {
        $rdvs = Rdv::where('patient_id',Auth::guard('patient')->user()->id)->get();
        $date = new DateTime('today');
        $dateHier = new DateTime();
      
        $dateHier->sub(new DateInterval('PT24H'));
        
      
        return view ('patient.rdvPatient.mesRendezVous',[
            'rdvs' =>$rdvs,
            'auj' =>$date,
            'hier' =>$dateHier,
        ]);
    }


    //permets à un Patient d'annuler son rendez-vous
    public function annulerRdvPat($id){

        $rdv = Rdv::find($id);
        //récupère le médecin lier à ce rendez-vous
        $medecin = Medecin::where('inami',$rdv->inami_med)->first();

        $client = $this->client;
        //crée un nouveau google service
        $service = new Google_Service_Calendar($client);
        //supprime l'évènement au niveau de l'api google en indiquant l'agenda et l'id de l'évènement
        $eventDelete = $service->events->delete($medecin->gCal_id,$rdv->gEventId);
        //modifie le statut du rendez-vous en base de données
        $rdv->statut = 'annuler';
        $rdv->save();
        
        return redirect()->back()->with('succes','Votre rendez-vous a bien été annulé');

    }
    //renvoie une liste de rendez-vous 
    public function afficherListeRdv(){

        $auj = new DateTime('today');
        $demain = new DateTime('today');
        $demain->add(new DateInterval('P1D'));
        $rdvs = Rdv::where('dateRdv','>=',$auj)->orderByDesc('dateRdv')->get();
        return view('secretaire.secPatient.listeRdvPatient',[
            'rdvs' =>$rdvs,
        ]);
    }
    //permets de filtrer les rdv par jour
    public function listeRdvJour(Request $request){
        if($request->ajax()){
            $auj = new DateTime('today');
            $demain = new DateTime('today');
            $demain->add(new DateInterval('P1D'));
            
                $rdvs = Rdv::whereBetween('dateRdv',[$auj,$demain])->where('statut','actif')->get()->load('patient')->load('medecin');
                return response()->json($rdvs);
            
        }
    }
    //permets de filtrer les rdv par semaine
    public function listeRdvSemaine(Request $request){
        if($request->ajax()){
            $auj = new DateTime('today');
            $semaine = new DateTime('today');
            $semaine->add(new DateInterval('P1W'));
            
                $rdvs = Rdv::whereBetween('dateRdv',[$auj,$semaine])->where('statut','actif')->get()->load('patient')->load('medecin');
                return response()->json($rdvs);
            
        }

    }
    //permets de filtrer les rdv par mois
    public function listeRdvMois(Request $request){
        if($request->ajax()){
            $auj = new DateTime('today');
            $mois = new DateTime('today');
            $mois->add(new DateInterval('P1M'));
            
                $rdvs = Rdv::whereBetween('dateRdv',[$auj,$mois])->where('statut','actif')->get()->load('patient')->load('medecin');
                return response()->json($rdvs);
            
        }

    }   
    //affiche pour une/un secrétaire le formulaire de prise de rendez-vous
    public function afficherPriseRdv(){
        $medecins = Medecin::where('statut','actif')->get();
        $date = new DateTime();
        $date->modify('+1 month');
        $patients =Patient::all();
        return view('secretaire.secPatient.secPrendreRdv',[
            'patients'=>$patients,
            'medecins'=>$medecins,
            'date'=>$date
        ]);
    }
    // affiche l'historique des rdvs pour la secrétaire
    public function historiqueRdv(){

        $rdvs = Rdv::where('statut','!=','actif')->get();

        return view('secretaire.secPatient.historiqueRdv',[
            'rdvs' =>$rdvs,
        ]);
    }
    //affiche le formulaire d'ajout d'un rdv pour un médecin
    public function medAfficherPriseRdv(){
        
        $date = new DateTime();
        $date->modify('+1 month');
        $patients = Patient::all();
        return view('medecin.medCreeRdv',[
            'patients' =>$patients,
            'date'=>$date
        ]);
    }
    //affiche l'historique des rdv d'un patient
    public function historiqueRdvPat(){
        return view('patient.rdvPatient.historiqueRdv');
    }
    //affiche l'agenda pour un médecin
    public function agendaMed(){
        return view('medecin.agenda');
    }

    //affiche l'agenda de la secrétaire
    public function secAgenda(){
        $medecin = Medecin::where('statut','actif')->get();
        return view('secretaire.secAgenda',[
            'medecin'=>$medecin,
        ]);
    }
}
