<?php

namespace App\Http\Controllers;

use App\Mail\AnnulerRdv;
use App\Mail\ConfirmationRdv;
use App\Medecin;
use App\Patient;
use App\Rdv;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;
use DateTime;
use DateInterval;
use Illuminate\Support\Facades\Mail;

class gCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
   protected $client;

    //fonction qui permet de créer un client google afin que celui-ci soit utilisé dans d'autre méthode du controlleur
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

   

    //fonction permettant à un patient de prendre rendez-vous.
    public function store(Request $request)
    {       
            $medecin = Medecin::find($request->id_medecin);

            $nom = Auth::guard('patient')->user()->nom;
            $rn = Auth::guard('patient')->user()->rn;

            $date_time = new DateTime($request->date);
        
            $date_time->setTime($request->heure, 0);
            
            $end_date_time = new DateTime($request->date);

            $end_date_time->setTime($request->heure+1, 0);

            $client = $this->client;
            $service = new Google_Service_Calendar($client);
            $event = new Google_Service_Calendar_Event(array(
                
                'summary' => "rdv : ".$nom." ".$rn." "."avec : Dr ".$medecin->nom,
                'location' => "Rue des trois gardes 344 schaerbeek 1030",
                'start' => array(
                    'dateTime' => date('c', $date_time->getTimestamp()),
                    'timeZone' => '',
                ),
                'end' => array(
                'dateTime' => date('c', $end_date_time->getTimestamp()),
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
        $calendarId = $medecin->gCal_id;
        $event = $service->events->insert($calendarId, $event, $params);

       $rdv =  Rdv::create([
            'dateRdv' => date('Y-m-d H:i:s',strToTime($event->start->dateTime)),
            'dateFinRdv' =>date('Y-m-d H:i:s',strToTime($event->end->dateTime)),
            'patient_id' => Auth::guard('patient')->user()->id,
            'inami_med' => $medecin->inami,
            'statut' => 'actif',
            'gEventId' =>$event->id,
        ]);
        
        $data = array('dateRdv'=>date('d/m/Y H:i:s',strToTime($rdv->dateRdv)) ,'medecin'=>$rdv->medecin->nom,'sexe'=>$rdv->patient->sexe,'nom'=>$rdv->patient->nom);
        
        Mail::to(Auth::guard('patient')->user()->email)->send(new ConfirmationRdv($data));

        return redirect('/patient')->with('succes','Votre rendez-vous a bien été enregistré. Un mail récapitulatif vous a été envoyé sur votre mail');

        
    }

    //fonction qui permet à un patient d'afficher le formulaire de prise de rendez-vous
    public function formRdv(){
        $patient = Patient::find(Auth::guard('patient')->user()->id);
        //si le patient a plus de 10 absence, il ne peut plus accéder au formulaire de prise de rendez-vous
        if($patient->rdv->where('statut','absent')->count() >10){
            return redirect('patient/mes rendez-vous')->with('erreur','Votre taux d\'absentéisme ne permet plus la prise de rendez-vous en ligne');
        }

        $medecins = Medecin::all();
     
        $date = new DateTime();
        $date->modify('+1 month');
        return view('patient.rdvPatient.prendreRdv',[
            'medecins' => $medecins,
            'date' =>$date,
        ]);
    }

    //cette fonction permet d'afficher via un appel ajax la liste des heures disponibles en fonction du jour choisi ainsi que du médecin
    public function heureDispo(Request $request){

        if($request->ajax()){
            
            $medecin = Medecin::find($request->medecin_id);

            $date = new DateTime($request->date);
    
            
    
            $day_after = new DateTime($request->date);
            $day_after->add(new DateInterval('P1D'));
    
            $innerHTML = [];
            for($i=0;$i<24;$i++) {
                $innerHTML_arr[] = "<option value='$i'>$i:00</option>";
            }
            for ($i=0; $i <9 ; $i++) { 
                 unset($innerHTML_arr[$i]);
            }
            unset($innerHTML_arr[12]);
            
            for ($i=18; $i <24 ; $i++) { 
                unset($innerHTML_arr[$i]);
            }
        
            $client = $this->client;
    
            $service = new Google_Service_Calendar($client);
            $calendarId = $medecin->gCal_id;
    
            $optParams = array(
              'timeMin' => date('c',$date->getTimestamp()),
              'timeMax' => date('c',$day_after->getTimestamp()),
            );
    
            $results = $service->events->listEvents($calendarId, $optParams);
            
            $the_html="";
            
            foreach ($results->getItems() as $event) {
                if(!empty($event->start->dateTime)){
                    $s = new DateTime($event->start->dateTime);
                    $d = new DateTime($event->start->dateTime);
                    $d->add(new DateInterval('PT1H'));
                    $e = new DateTime($event->end->dateTime);
                    $end = date('G',$e->getTimestamp());
                    $startPlus = date('G',$d->getTimestamp());
                    $start = date('G',$s->getTimestamp());

                    if($startPlus < $end){
                        for($start;$start<$end;$start++){
                            unset($innerHTML_arr[$start]);
                        }
                    }                           
                    unset($innerHTML_arr[$start]);
                
                }
            }
            $the_html.= implode("",$innerHTML_arr);
            
            return $the_html;

            }
        }

        //fonction permettant à une secrétaire de crée un rendez-vous
        public function secCreeRdv(Request $request){

        $data = $request->validate([
                'rn' => 'required','digits:11',
            ],
            [  
           
            'rn.digits' => 'Le numéro de registre national doit contenir 11 chiffres',
            'rn.required' =>'Le champ numéro de registre national ne peut être vide',
        ]
        );

            $medecin = Medecin::find($request->id_medecin);
            $patient = Patient::where('rn',$request->rn)->first();
           
            if(!$patient){
                return back()->with('succes','Aucun patient trouvé avec ce numéro de registre national');
            }
            $nom = $patient->nom;
           
            $rn = $patient->rn;

            $date_time = new DateTime($request->date);
        
            $date_time->setTime($request->heure, 0);
            
            $end_date_time = new DateTime($request->date);

            $end_date_time->setTime($request->heure+1, 0);

                

            $client = $this->client;
            $service = new Google_Service_Calendar($client);
            $event = new Google_Service_Calendar_Event(array(
                
                'summary' => "rdv : ".$nom." ".$rn." "."avec : Dr ".$medecin->nom,
                'location' => "Rue des trois gardes 344 schaerbeek 1030",
                'start' => array(
                    'dateTime' => date('c', $date_time->getTimestamp()),
                    'timeZone' => '',
                ),
                'end' => array(
                'dateTime' => date('c', $end_date_time->getTimestamp()),
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
        $calendarId = $medecin->gCal_id;
        $event = $service->events->insert($calendarId, $event, $params);

       $rdv =  Rdv::create([
            'dateRdv' => date('Y-m-d H:i:s',strToTime($event->start->dateTime)),
            'dateFinRdv' =>date('Y-m-d H:i:s',strToTime($event->end->dateTime)),
            'patient_id' => $patient->id,
            'inami_med' => $medecin->inami,
            'statut' => 'actif',
            'gEventId' =>$event->id,
        ]);
        
        $data = array('dateRdv'=>date('d/m/Y H:i:s',strToTime($rdv->dateRdv)) ,'medecin'=>$rdv->medecin->nom,'sexe'=>$rdv->patient->sexe,'nom'=>$rdv->patient->nom);
        if($patient->email){
            Mail::to($patient->email)->send(new ConfirmationRdv($data));
        }
        

        return redirect()->route('sec.afficher.rdv')->with('succes','Le rendez-vous a bien été enregistré');

        }




        //fonction permettant d'annuler un rendez-vous.Quand cette fonction est appelé un mail est envoyer au patient si celui ci posséde une adresse mail
        public function secAnnulerRdv($id){
            $rdv = Rdv::find($id);
        
            $medecin = Medecin::where('inami',$rdv->inami_med)->first();

            $client = $this->client;
            $service = new Google_Service_Calendar($client);
            $eventDelete = $service->events->delete($medecin->gCal_id,$rdv->gEventId);

            $rdv->statut = 'annuler';
            $rdv->save();

            $data = array('dateRdv'=>date('d/m/Y H:i',strToTime($rdv->dateRdv)) ,'medecin'=>$rdv->medecin->nom,'sexe'=>$rdv->patient->sexe,'nom'=>$rdv->patient->nom);
            if($rdv->patient->email){
                Mail::to($rdv->patient->email)->send(new AnnulerRdv($data));
            }
            
            return redirect()->back()->with('succes','Votre rendez-vous a bien été annulé');
        }


        //fonction permettant à une secrétaire d'indiquer si un patient c'est présenté à son rendez-vous
        public function secPresentRdv($id){
            $rdv = Rdv::find($id);
    
            $rdv->statut = 'present';
            $rdv->save();
            
            return redirect()->back()->with('succes','Tâche effectuée avec succès');
        }


        //fonction permettant à une secrétaire d'indiquer si un patient n'est pas venu à son rendez-vous
        public function secAbsentRdv($id){
            $rdv = Rdv::find($id);
    
            $rdv->statut = 'absent';
            $rdv->save();
            
            return redirect()->back()->with('succes','Tâche effectuée avec succès');
        }


        //cette fonction permet via un appel en ajax d'afficher la liste des heures disponibles pour un jour choisi par l'utilisateur
        public function medHeureDispo(Request $request){
            if($request->ajax()){
            
                
    
                $date = new DateTime($request->date);
        
                
        
                $day_after = new DateTime($request->date);
                $day_after->add(new DateInterval('P1D'));
        
                $innerHTML = [];
                for($i=0;$i<24;$i++) {
                    $innerHTML_arr[] = "<option value='$i'>$i:00</option>";
                }
                for ($i=0; $i <9 ; $i++) { 
                     unset($innerHTML_arr[$i]);
                }
                unset($innerHTML_arr[12]);
                
                for ($i=18; $i <24 ; $i++) { 
                    unset($innerHTML_arr[$i]);
                }

                $client = $this->client;
        
                $service = new Google_Service_Calendar($client);
                $calendarId = Auth::guard('medecin')->user()->gCal_id;
        
                $optParams = array(
                  'timeMin' => date('c',$date->getTimestamp()),
                  'timeMax' => date('c',$day_after->getTimestamp()),
                );
        
                $results = $service->events->listEvents($calendarId, $optParams);
                
                $the_html="";
                
                foreach ($results->getItems() as $event) {
                    if(!empty($event->start->dateTime)){
                        $s = new DateTime($event->start->dateTime);
                        $d = new DateTime($event->start->dateTime);
                        $d->add(new DateInterval('PT1H'));
                        $e = new DateTime($event->end->dateTime);
                        $end = date('G',$e->getTimestamp());
                        $startPlus = date('G',$d->getTimestamp());
                        $start = date('G',$s->getTimestamp());

                        if($startPlus < $end){
                            for($start;$start<$end-1;$start++){
                                unset($innerHTML_arr[$start]);
                            }
                        }
                           
                        
                        unset($innerHTML_arr[$start]);
                    
                    }
                       
                }
                $the_html.= implode("",$innerHTML_arr);
                
                return $the_html;
            }
        }



        //fonction permettant à un médecin de crée un rendez-vous. Cette fonction est différente des autres car on récupere le calendrier du médecin connecté 
        public function medCreeRdv(Request $request){
            
            $data = $request->validate([
                'rn' =>['required','digits:11'],
                'date' =>['required','date'],
                
            ],
            [  
            'date.required'=> 'vous devez sélectionner une date',
            'rn.digits' => 'Le numéro de registre national doit contenir 11 chiffres',
            'rn.required' =>'Le champ numéro de registre national ne peut être vide',
        ]
        );


            $medecin =  Auth::guard('medecin')->user();
            $patient = Patient::where('rn',$request->rn)->first();
           
            if(!$patient){
                return back()->with('succes','Aucun patient trouvé avec ce numéro de registre national');
            }
            $nom = $patient->nom;
           
            $rn = $patient->rn;

            $date_time = new DateTime($request->date);
        
            $date_time->setTime($request->heure, 0);
            
            $end_date_time = new DateTime($request->date);

            $end_date_time->setTime($request->heure+1, 0);

                

            $client = $this->client;
            $service = new Google_Service_Calendar($client);
            $event = new Google_Service_Calendar_Event(array(
                
                'summary' => "rdv : ".$nom." ".$rn." "."avec : Dr ".$medecin->nom,
                'location' => "Rue des trois gardes 344 schaerbeek 1030",
                'start' => array(
                    'dateTime' => date('c', $date_time->getTimestamp()),
                    'timeZone' => '',
                ),
                'end' => array(
                'dateTime' => date('c', $end_date_time->getTimestamp()),
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
        $calendarId = $medecin->gCal_id;
        $event = $service->events->insert($calendarId, $event, $params);

       $rdv =  Rdv::create([
            'dateRdv' => date('Y-m-d H:i:s',strToTime($event->start->dateTime)),
            'dateFinRdv' =>date('Y-m-d H:i:s',strToTime($event->end->dateTime)),
            'patient_id' => $patient->id,
            'inami_med' => $medecin->inami,
            'statut' => 'actif',
            'gEventId' =>$event->id,
        ]);
        
        $data = array('dateRdv'=>date('d/m/Y H:i',strToTime($rdv->dateRdv)) ,'medecin'=>$rdv->medecin->nom,'sexe'=>$rdv->patient->sexe,'nom'=>$rdv->patient->nom);
        if($patient->email){
            Mail::to($patient->email)->send(new ConfirmationRdv($data));
        }
        

        return redirect()->route('med.afficher.rdv')->with('succes','Le rendez-vous a bien été enregistré');

        }

        // fonction permettant à une secrétaire et à un médecin d'imprimer les rendez-vous
        public function secImprimerRdv($id){
            $rdv = Rdv::find($id);
            $data = array(
                'dateRdv'=>date('d/m/Y H:i',strToTime($rdv->dateRdv)),
                 'medecin'=>$rdv->medecin->nom,
                 'sexe'=>$rdv->patient->sexe,
                 'nom'=>$rdv->patient->nom
            );
            $pdf = \PDF::loadView('recapRdv', $data);  
            return $pdf->download('recap rendez-vous'.' '.$rdv->patient->nom.'.pdf');
        }


   }
