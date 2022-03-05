<?php

namespace App\Http\Controllers;

use App\DossierMed;
use App\Analyse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class AnalyseController extends Controller
{
   //permets d'afficher le formulaire d'ajout d'analyse
    public function index($id)
    {
        return view('medecin.analyse.ajouterAnalyse',[
            'patient' => $id,
        ]);
    }
    //permets d crée une instance de la classe Analyse
    public function store(Request $request)
    {
        $data = $request->validate([
            'typeAnalyse' => 'required|string',
            'fichier' => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:20000',
        ]
    );
        $fileName = $request->fichier->getClientOriginalName();
        $request->fichier->storeas('analyse',$fileName);   
        Analyse::create([
            'typeAnalyse' => $data['typeAnalyse'],
            'patient_id' =>$request->get('id_patient'),
            'inami_med' => Auth::guard('medecin')->user()->inami,
            'lienFichier' => $fileName,
            'statut' => 'actif',
            
        ]);
        
        $dossier = DossierMed::where('patient_id',$request->get('id_patient'))->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    //permets d'afficher une analyse 
    public function show($lien)
    {
        $path = public_path('analyse/'.$lien);
        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        
    
        $type = File::mimeType($path);
    
    
    
        $response = Response::make($file, 200);
    
        $response->header("Content-Type", $type);
    
    
    
        return $response;
    }

    

    //permets de faire une suppression logique d'une analyse 
    public function destroy($id)
    {
        $analyse = Analyse::find($id);
       
        $analyse->statut = 'inactif';
        
        $analyse->save();
       

        $dossier = DossierMed::where('patient_id',$analyse->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }
}
