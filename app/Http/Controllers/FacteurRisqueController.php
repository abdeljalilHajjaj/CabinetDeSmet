<?php

namespace App\Http\Controllers;

use App\FacteurRisque;
use App\DossierMed;
use Illuminate\Http\Request;

class FacteurRisqueController extends Controller
{   
    //affiche le formulaire d'ajout d'un facteur de risque
    public function index($id)
    {
        return view('medecin.facteur.ajouterFacteur',[
            'patient' => $id,
        ]);
    }
    //crée une instance de la classe FacteurRisque et stocke l'objet en db
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
        ]);

        FacteurRisque::create([
            'description' => $data['description'],
            'patient_id' => $request->get('id_patient'),
            'inami_med' => $request->get('inami'),
            'statut' =>'actif',
        ]);
        

        $dossier = DossierMed::where('patient_id',$request->get('id_patient'))->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    //affiche un facteur de risque
    public function show($id)
    {
        $facteur = FacteurRisque::where('id',$id)->first();

        return view('medecin.facteur.voirFact',[
            'facteur' => $facteur
        ]);
    }

    //affiche le formulaire de modification d'un facteur de risque
    public function edit($id)
    {
        $facteur = FacteurRisque::where('id',$id)->first();
        return view('medecin.facteur.modifierFacteur',[
            'facteur' => $facteur,
        ]);
    }

    //modifie un facteur de risque et enregistre les modifs en db
    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|numeric',
            'description' => 'required|string',
            'inami' => 'required|numeric',
        ]);
        $facteur = FacteurRisque::where('id',$data['id'])->first();
        $facteur->description = $data['description'];
        $facteur->inami_med = $data['inami'];
        $facteur->save();
        $dossier = DossierMed::where('patient_id',$facteur->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    //suppression logique d'un FacteurRisque
    public function destroy($id)
    {
        $facteur = FacteurRisque::find($id);
        $facteur->statut = 'inactif';
        $facteur->save();
        $dossier = DossierMed::where('patient_id',$facteur->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

}
