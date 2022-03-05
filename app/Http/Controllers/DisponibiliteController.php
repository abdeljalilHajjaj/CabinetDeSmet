<?php

namespace App\Http\Controllers;

use App\Disponibilite;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;


class DisponibiliteController extends Controller
{

        public function __construct()
        {
            $client = new Google_Client();
            $client->setAuthConfig('client_secret.json');
            $client->addScope(Google_Service_Calendar::CALENDAR);
            $client->setAccessType('offline');
            $client->setIncludeGrantedScopes(true);

            $guzzleClient = new \GuzzleHttp\Client(array('verify'=>false,'curl' => array(CURLOPT_SSL_VERIFYPEER => false)));
            $client->setHttpClient($guzzleClient);
            $this->client = $client;
        }

    
        public function afficherDispo(){
            
            return view('medecin.disponibilite.listeDispo');
        }


        public function afficherFormDispo(){
            return view('medecin.disponibilite.ajouterDispo');
        }


        public function creerDispo(Request $request){
            $request->validate(
                [
                    'dateDebut'=>'required',
                    'dateFin'=>'required',
                    'details'=>'required|string|max:150',
            ]);
            $dateDebut = new DateTime($request->dateDebut);
            $dateFin = new DateTime($request->dateFin);
            
            $client = $this->client;
            $service = new Google_Service_Calendar($client);
            $event = new Google_Service_Calendar_Event(array(
                
                'summary' => "événement : ".' '.$request->details.' '.'Dr '.Auth::guard('medecin')->user()->nom,
                'location' => "Rue des trois gardes 344 schaerbeek 1030",
                'start' => array(
                    'dateTime' => date('c', $dateDebut->getTimestamp()),
                    'timeZone' => '',
                ),
                'end' => array(
                'dateTime' => date('c', $dateFin->getTimestamp()),
                'timeZone' => '',
                ),
                'anyoneCanAddSelf' => "true",

                'attendees' => array(
                   
                
                ),

                'guestsCanInviteOthers' => FALSE,
                
                'visibility' => "public",

                'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
                ),
            ));

        $params = [ "sendNotifications" => "true" ];
        $calendarId = Auth::guard('medecin')->user()->gCal_id ;
        $event = $service->events->insert($calendarId, $event, $params);

        $disponibilite = Disponibilite::create([
            'details' => $request->details,
            'dateDebut' =>$request->dateDebut,
            'dateFin' =>$request->dateFin,
            'gEventId' =>$event->id,
            'inami_med' =>Auth::guard('medecin')->user()->inami,
            'statut'=>'actif',
        ]);

        return redirect()->route('med.dispo')->with('succes','l\'événement a bien été crée');


        }


        public function suppDispo($id){
            $dispo = Disponibilite::find($id);
            $client = $this->client;
            $service = new Google_Service_Calendar($client);
            $eventDelete = $service->events->delete(Auth::guard('medecin')->user()->gCal_id,$dispo->gEventId);

            $dispo->statut = 'annuler';
            $dispo->save();
            
            return redirect()->back()->with('succes','La tâche a bien été effectué');
        }

}
