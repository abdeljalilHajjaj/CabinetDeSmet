<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Inscription;
use App\Providers\RouteServiceProvider;
use App\Patient;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * 
     */
    protected $redirectTo = '/patient';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:patient')->except('logout');
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'rn' => ['required','digits:11','unique:patients'],
            'tel' => ['required','digits:10'],
            'name' => ['required', 'string', 'max:255'],
            'date_naiss' => ['required'],
            'sexe' => ['required'],
            'prenom' => ['required', 'string', 'max:255'],
            'adresse' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:patients'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
         [   'rn.unique' => 'Le numéro de registre national existe déjà dans notre base de données',
             'rn.digits' => 'Le numéro de registre national doit contenir 11 chiffres',
             'rn.required' =>'Le champ numéro de registre national ne peut être vide',
         ]
    
    );
    
    }

    /**
     * Crée une nouvelle instance de Patient après vérification de l'inscription
     *
     * @param  array  $data
     * @return \App\Patient
     */
    protected function create(array $data)
    {
       $patient = Patient::create([
            'rn' =>$data['rn'],
            'tel' =>$data['tel'],
            'nom' => $data['name'],
            'prenom' => $data['prenom'],
            'date_naiss' =>$data['date_naiss'],
            'sexe' => $data['sexe'],
            'adresse' => $data['adresse'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'statut' => 'en attente',
        ]);

        Mail::to($data['email'])->send(new Inscription($data));
        return  $patient;

        
    }
   
}
