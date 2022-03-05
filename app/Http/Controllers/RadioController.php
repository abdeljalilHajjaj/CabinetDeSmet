<?php

namespace App\Http\Controllers;

use App\DossierMed;
use App\Radio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class RadioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('medecin.radio.ajouterRadio',[
            'patient' => $id,
        ]);
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'details' => 'required|string',
            'fichier' => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:20000',
        ]
       
    
    );
        $fileName = $request->fichier->getClientOriginalName();
        $request->fichier->storeas('radio',$fileName);
       
            
        Radio::create([
            'details' => $data['details'],
            'patient_id' =>$request->get('id_patient'),
            'inami_med' => Auth::guard('medecin')->user()->inami,
            'lien' => $fileName,
            'statut' => 'actif',
            
        ]);
        

        $dossier = DossierMed::where('patient_id',$request->get('id_patient'))->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($lien)
    {
        
        $path = public_path('radio/'.$lien);



        if (!File::exists($path)) {
    
            abort(404);
    
        }
    
    
    
        $file = File::get($path);
        
    
        $type = File::mimeType($path);
    
    
    
        $response = Response::make($file, 200);
    
        $response->header("Content-Type", $type);
    
    
    
        return $response;
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $radio = Radio::find($id);
       
        $radio->statut = 'inactif';
        
        $radio->save();
       

        $dossier = DossierMed::where('patient_id',$radio->patient_id)->first();
        return redirect()->route('dossierMed',[$dossier->patient_id]);

    }
}
