<?php

namespace App\Http\Controllers;

use App\Antecedent;
use App\DossierMed;
use Illuminate\Http\Request;

class AntecedentController extends Controller
{
    //affiche le formulaire d'ajout d'antécédent
    public function index($id)
    {
        return view('medecin.antecedent.ajouterAnte',[
            'patient' => $id,
        ]);
    }
    //crée et enregistre en base de donnée une instance de la classe Antecedent
    public function store(Request $request)
    {
        $data = $request->validate([
            'description' => 'required|string',
        ]);

        Antecedent::create([
            'description' => $data['description'],
            'patient_id' => $request->get('id_patient'),
            'inami_med' => $request->get('inami'),
            'statut' =>'actif',
        ]);
        

        $dossier = DossierMed::where('patient_id',$request->get('id_patient'))->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

   //affiche un antécédent choisi 
    public function show($id)
    {
        $antecedent = Antecedent::where('id',$id)->first();

        return view('medecin.antecedent.voirAnte',[
            'antecedent' => $antecedent,
        ]);
    }


    

    //affiche le formulaire de modification d'un antécédent
    public function edit($id)
    {
        $antecedent = Antecedent::where('id',$id)->first();
        return view('medecin.antecedent.modifierAntecedent',[
            'antecedent' => $antecedent,
        ]);
    }

    //mets à jour un antécédent
    public function update(Request $request)
    {
       
        $data = $request->validate([
            'id' => 'required|numeric',
            'description' => 'required|string',
            'inami' => 'required|numeric',
        ]);
       
        $antecedent = Antecedent::where('id',$data['id'])->first();
        
        $antecedent->description = $data['description'];
        $antecedent->inami_med = $data['inami'];
        $antecedent->save();

        $dossier = DossierMed::where('patient_id',$antecedent->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

   //permets la suppression logique d'un antécédent
    public function destroy($id)
    {
        $antecedent = Antecedent::find($id);
       
        $antecedent->statut = 'inactif';
        
        $antecedent->save();
       

        $dossier = DossierMed::where('patient_id',$antecedent->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }
}
