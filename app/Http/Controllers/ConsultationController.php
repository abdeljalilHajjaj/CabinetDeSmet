<?php

namespace App\Http\Controllers;

use App\Consultation;
use App\DossierMed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    //retourne le formulaire d'ajout d'une consultation
    public function index($id)
    {
        return view('medecin.consultation.ajouterConsult',[
            'patient' => $id,
        ]);
    }

    
    

    //permets de créer une instance de la classe Consultation et stocker l'objet dans la table consultations.
    public function store(Request $request)
    {
        $data = $request->validate([
            'motif' => 'required|string',
            'objectif' => 'required|string',
            'subjectif' => 'required|string',
            'plan' => 'required|string',
            'taille' =>'required|numeric|min:0|max:250',
            'temperature' =>'required|numeric',
            'poids' =>'required|numeric',
            'sys' =>'required|numeric|min:0|max:50',
            'dia' =>'required|numeric|min:0|max:50',
            'rythme_card' =>'required|numeric|min:0',
            'saturation_oxygene' => 'required|numeric|min:0|max:100',
            'id_patient' =>'required|integer'
        ],
        [
            'dia.max' => 'La pression artérielle diastolique doit être inférieur à 50',
            'dia.min' => 'La pression artérielle diastolique doit être supérieur à 0',
            'sys.max' => 'La pression artérielle systolique doit être inférieur à 50',
            'sys.min' => 'La pression artérielle systolique doit être supérieur à 0',
        ]
    
    );
        
       
            
        Consultation::create([
            'motif' => $data['motif'],
            'objectif' => $data['objectif'],
            'subjectif' => $data['subjectif'],
            'planSuivi' => $data['plan'],
            'patient_id' => $request->get('id_patient'),
            'inami_med' => Auth::guard('medecin')->user()->inami,
            'taille' => $data['taille'],
            'temperature' => $data['temperature'],
            'poids' => $data['poids'],
            'pa_sys' => $data['sys'],
            'pa_dia' => $data['dia'],
            'rythme_card' => $data['rythme_card'],
            'saturation_oxygene' => $data['saturation_oxygene'],
            'statut' => 'actif',
            
        ]);
        

        $dossier = DossierMed::where('patient_id',$request->get('id_patient'))->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    //affiche une consultation
    public function show($id)
    {
        $consultation = Consultation::where('id',$id)->first();

        return view('medecin.consultation.voirConsult',[
            'consultation' => $consultation,
        ]);
    }

    //affiche le formulaire de modification d'une consultation
    public function edit($id)
    {
        $consultation = Consultation::find($id);

        return view('medecin.consultation.modifierConsultation',[
            'consultation' => $consultation,
        ]);
    }

    //modifie une consultation et enregistre la modification en db
    public function update(Request $request)
    {
        $data = $request->validate([
            'motif' => 'required|string',
            'objectif' => 'required|string',
            'subjectif' => 'required|string',
            'plan' => 'required|string',
            'taille' =>'required|numeric|min:0|max:250',
            'temperature' =>'required|numeric',
            'poids' =>'required|numeric',
            'sys' =>'required|numeric|min:0|max:50',
            'dia' =>'required|numeric|min:0|max:50',
            'rythme_card' =>'required|numeric|min:0',
            'saturation_oxygene' => 'required|numeric|min:0|max:100',
            
        ],
        [
            'dia.max' => 'La pression artérielle diastolique doit être inférieur à 50',
            'dia.min' => 'La pression artérielle diastolique doit être supérieur à 0',
            'sys.max' => 'La pression artérielle systolique doit être inférieur à 50',
            'sys.min' => 'La pression artérielle systolique doit être supérieur à 0',
        ]
    
    );
       
        $consultation = Consultation::where('id',$request->id)->first();
        
        $consultation->motif = $data['motif'];
        $consultation->objectif = $data['objectif'];
        $consultation->subjectif = $data['subjectif'];
        $consultation->planSuivi = $data['plan'];
        $consultation->inami_med = Auth::guard('medecin')->user()->inami;
        $consultation->taille = $data['taille'];
        $consultation->poids = $data['poids'];
        $consultation->pa_sys = $data['sys'];
        $consultation->pa_dia = $data['dia'];
        $consultation->temperature = $data['temperature'];
        $consultation->rythme_card = $data['rythme_card'];
        $consultation->saturation_oxygene = $data['saturation_oxygene'];

        $consultation->save();

        $dossier = DossierMed::where('patient_id',$consultation->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    //permets la suppression logique d'une consultation
    public function destroy($id)
    {
        $consultation = Consultation::find($id);
       
        $consultation->statut = 'inactif';
        
        $consultation->save();
       

        $dossier = DossierMed::where('patient_id',$consultation->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }
}
