<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Medecin;
use App\Patient;
use App\Providers\RouteServiceProvider;
use App\Secretaire;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;
    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:patient')->except('logout');
        $this->middleware('guest:medecin')->except('logout');
        $this->middleware('guest:secretaire')->except('logout');       
    }
    //affiche le formulaire d'authentification pour un médecin
    public function showMedecinLoginForm()
    {
        return view('auth.login', ['url' => 'Médecin']);
    }
    //permet l'authentification d'un médecin
    public function medecinLogin(Request $request)
    {
        $medecin = Medecin::where('email',$request->email)->first();

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
     
        if (Auth::guard('medecin')->attempt(['email' => $request->email, 'password' => $request->password,'statut'=>'actif'], $request->get('remember'))) {
            
            return redirect()->intended('/medecin/mes rendez-vous');
        }
        if($medecin){
            if($medecin->statut !== 'actif'){
                return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Veuillez contacter votre administrateur car vous n\'avez plus les accès']);
            }
        }
       
        return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Le mot de passe ou l\'adresse email n\'est pas valide']);
    }
       //affiche le formulaire d'authentification pour un patient
    public function showPatientLoginForm()
    {
        return view('auth.login', ['url' => 'Patient']);
    }
    //permet l'authentification d'un patient
    public function patientLogin(Request $request)
    {
        $patient = Patient::where('email',$request->email)->first();
        
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
     
        if (Auth::guard('patient')->attempt(['email' => $request->email, 'password' => $request->password,'statut'=>'actif'], $request->get('remember'))) {
           
            return redirect()->intended('/patient/mes rendez-vous');
        }
        if($patient){
            if($patient->statut == 'en attente'){
                return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Vous ne pouvez actuellement pas vous connecter car votre inscription n\'est pas finalisée.Un mail vous expliquant la procédure vous a été envoyé, si ce n\'est pas le cas, veuillez nous contacter.Pour ce faire voir la page contact']);
            }
            if($patient !== 'actif'){
                return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Votre compte a été suspendu. Veuillez nous contacter pour plus d\'informations. Pour ce faire voir la page contact']);
            }
        }

        return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Le mot de passe ou l\'adresse email n\'est pas valide']);;
    }
    //affiche le formulaire d'authentification pour une secrétaire
    public function showSecretaireLoginForm()
    {
        return view('auth.login', ['url' => 'Secrétaire']);
    }
      //permet l'authentification d'une secrétaire
    public function secretaireLogin(Request $request)
    {
        $secretaire = Secretaire::where('email',$request->email)->first();

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);
     
        if (Auth::guard('secretaire')->attempt(['email' => $request->email, 'password' => $request->password,'statut'=>'actif'], $request->get('remember'))) {
     
            return redirect()->intended('/secretaire/liste patient en attente');
        }


        if($secretaire){
            if($secretaire->statut !== 'actif'){
                return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Veuillez contacter votre administrateur car vous n\'avez plus les accès']);
            }
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors(['msg'=>'Le mot de passe ou l\'adresse email n\'est pas valide']);;
    }

    
}
