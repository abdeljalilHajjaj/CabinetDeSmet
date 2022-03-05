<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Antecedent;
use App\Patient;
use App\DossierMed;
use App\Medicament;
use App\Ordonnance;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateInterval;


class OrdonnanceController extends Controller
{
    
    public function index($id)
    {
        $medicaments = Medicament::where('statut','actif')->get();
        return view('medecin.ordonnance.ajouterOrd',[
            'patient' =>$id,
            'medicaments'=>$medicaments
        ]);
    }

    public function store(Request $request)
    {
       
            $patient = Patient::find($request->id_patient);
            $test = implode($request->list);
            $ordonnance = Ordonnance::create([
                'listeMedic'=>$test,
                'patient_id'=>$patient->id,
                'inami_med'=>Auth::guard('medecin')->user()->inami,
                'statut'=>'actif',
            ]);
            $dossier = DossierMed::where('patient_id',$ordonnance->patient_id)->first();
            return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $dateFin = new DateTime('today');
        $dateFin->add(new DateInterval('P3M'));
        $ord = Ordonnance::find($id);
        
      

        $data = array(
            'nomPatient'=>$ord->patient->nom,
            'prenomPatient'=>$ord->patient->prenom,
            'rn'=>$ord->patient->rn,
            'nomMedecin'=>$ord->medecin->nom,
            'prenomMedecin'=>$ord->medecin->prenom,
            'inami'=>$ord->medecin->inami,
            'medicament'=>explode(',',$ord->listeMedic),
            'datefin'=>$dateFin,
            'codeBarre'=>rand(10000000,99999999),
            
        );
        
        $pdf = \PDF::loadView('ordonnance', $data);  
        return $pdf->download('ordonnance.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ordonnance = Ordonnance::find($id);
        $ordonnance->statut = 'inactif';
        $ordonnance->save();
        $dossier = DossierMed::where('patient_id',$ordonnance->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }
}
