<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('test','gCalendarController@index');
Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/contact',function(){
    return view('contact');
})->name('contact');

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

//Routes pour l'affichage et l'envoie du formulaire d'authentification en tant que patient
Route::get('/login/patient', 'Auth\LoginController@showPatientLoginForm');
Route::post('/login/patient', 'Auth\LoginController@patientLogin');

//groupe de routes pour la guard "patient". Empeche les utilisateurs autres que Patient d'accéder ces pages
Route::group(['middleware' => 'auth:patient'],function(){
    Route::view('/patient','patient.index');
    Route::get('patient/Profil','PatientController@index')->name('Profil');
    Route::post('patient/profil','PatientController@update')->name('modifProfil');
    Route::get('patient/prise rendez-vous','gCalendarController@formRdv')->name('patient.afficher.prendre.rdv');
    Route::post('patient/heureDispo','gCalendarController@heureDispo')->name('patient.heureDispo'); 
    Route::post('patient/crée rendez-vous','gCalendarController@store')->name('cree.rdv');
    Route::get('patient/mes rendez-vous','RdvController@index')->name('afficher.liste.rdv');
    Route::get('patient/annulerRdv{id?}','RdvController@annulerRdvPat')->name('annuler.rdv.pat');
    Route::get('patient/historique des rendez-vous','RdvController@historiqueRdvPat')->name('histo.rdv');

});


//Routes pour l'affichage et l'envoie du formulaire d'authentification en tant que médecin 
Route::get('/login/medecin', 'Auth\LoginController@showMedecinLoginForm');
Route::post('/login/medecin', 'Auth\LoginController@medecinLogin');

//groupe de routes pour la guard "medecin". Empeche les utilisateurs autres que Medecin d'accéder ces pages
Route::group(['middleware' => 'auth:medecin'],function(){
    Route::view('/medecin','medecin.index');
    Route::get('/medecin/listePatient','MedecinController@listPatient');

    Route::get('/medecin/dossierMed/{id?}','DossierMedController@dossier')->name('dossierMed');

    
    //route pour les antecedent
    Route::get('/medecin/voirAntecedent/{id?}','AntecedentController@show')->name('voir.antecedent');
    Route::get('/medecin/ajouterAntecedent/{id?}','AntecedentController@index')->name('afficher.ajouter.antecedent');
    Route::post('/medecin/ajouterAntecedent','AntecedentController@store')->name('ajouter.antecedent');
    Route::get('/medecin/modifierAntecedent/{id?}','AntecedentController@edit')->name('afficher.modifier.antecedent');
    Route::post('/medecin/modifierAntecedent','AntecedentController@update')->name('modifier.antecedent');
    Route::get('/medecin/suppAntecedent/{id?}','AntecedentController@destroy')->name('supp.antecedent');


    Route::get('/medecin/voirFacteur/{id?}','FacteurRisqueController@show')->name('voir.facteur');
    Route::get('/medecin/ajouterFacteur/{id?}','FacteurRisqueController@index')->name('afficher.ajouter.facteur');
    Route::post('/medecin/ajouterFacteur','FacteurRisqueController@store')->name('ajouter.facteur');
    Route::get('/medecin/modifierFacteur/{id?}','FacteurRisqueController@edit')->name('afficher.modifier.facteur');
    Route::post('/medecin/modifierFacteur','FacteurRisqueController@update')->name('modifier.facteur');
    Route::get('/medecin/suppFacteur/{id?}','FacteurRisqueController@destroy')->name('supp.facteur');

    //ligne à modifier 
    Route::get('/medecin/ajouterOrd/{id?}','OrdonnanceController@index')->name('afficher.ajouter.ord');
    Route::get('/medecin/voirOrd/{id?}','OrdonnanceController@show')->name('voir.ordonnance');
    Route::get('/medecin/suppOrd/{id?}','OrdonnanceController@destroy')->name('supp.ordonnance');
    Route::post('/medecin/ajouterOrd','OrdonnanceController@store')->name('ajouter.ord');

    Route::get('/medecin/voirConsultation/{id?}','ConsultationController@show')->name('voir.consultation');
    Route::get('/medecin/ajouterConsultation/{id?}','ConsultationController@index')->name('afficher.ajouter.consultation');
    Route::post('/medecin/ajouterConsultation','ConsultationController@store')->name('ajouter.consultation');
    Route::get('/medecin/modifierConsultation/{id?}','ConsultationController@edit')->name('afficher.modifier.consultation');
    Route::post('/medecin/modifierConsultation','ConsultationController@update')->name('modifier.consultation');
    Route::get('/medecin/suppConsultation/{id?}','ConsultationController@destroy')->name('supp.consultation');



    Route::get('/medecin/ajouterRadio/{id?}','RadioController@index')->name('afficher.ajouter.radio');
    Route::post('/medecin/ajouterRadio','RadioController@store')->name('ajouter.radio');
    Route::get('/medecin/afficherRadio/{lien?}','RadioController@show')->name('afficher.radio');
    Route::get('/medecin/suppRadio/{id?}','RadioController@destroy')->name('supp.radio');


    Route::get('/medecin/ajouterAnalyse/{id?}','AnalyseController@index')->name('afficher.ajouter.analyse');
    Route::post('/medecin/ajouterAnalyse','AnalyseController@store')->name('ajouter.analyse');
    Route::get('/medecin/afficherAnalyse/{lien?}','AnalyseController@show')->name('afficher.analyse');
    Route::get('/medecin/suppAnalyse/{id?}','AnalyseController@destroy')->name('supp.analyse');


    Route::get('/medecin/test','gCalendarController@index');



    Route::get('/medecin/mes rendez-vous','MedecinController@listeRdv')->name('med.afficher.rdv');


    Route::get('/medecin/annulerRdv/{id?}','gCalendarController@secAnnulerRdv')->name('med.annuler.rdv');


    Route::get('/medecin/cree rdv patient','RdvController@medAfficherPriseRdv')->name('med.afficher.prendre.rdv');

    Route::post('/medecin/heureDispo','gCalendarController@medHeureDispo')->name('med.heureDispo'); 



    Route::post('/medecin/cree rdv patient','gCalendarController@medCreeRdv')->name('med.cree.rdv');


    Route::get('/medecin/dispo','DisponibiliteController@afficherDispo')->name('med.dispo');

    Route::get('/medecin/ajouter dispo','DisponibiliteController@afficherFormDispo')->name('med.form.dispo');
    Route::post('/medecin/ajouter dispo','DisponibiliteController@creerDispo')->name('med.creer.dispo');

    Route::get('/medecin/supprimerDispo{id?}','DisponibiliteController@suppDispo')->name('med.supp.dispo');

    Route::get('/medecin/agenda','RdvController@agendaMed')->name('med.agenda');

});



//Routes pour l'affichage et l'envoie du formulaire d'authentification en tant que secrétaire
Route::get('/login/secretaire', 'Auth\LoginController@showSecretaireLoginForm');
Route::post('/login/secretaire', 'Auth\LoginController@secretaireLogin');

//groupe de routes pour la guard "secretaire". Empeche les utilisateurs autres que Secretaire d'accéder ces pages
Route::group(['middleware' => 'auth:secretaire'],function(){
    Route::view('/secretaire','secretaire.index')->name('sec.index');

    Route::get('/secretaire/ajouterPatient','PatientController@viewAjouterPat')->name('sec.ajouter.pat');
    Route::post('/secretaire/ajouterPatient','PatientController@secAjouterPat')->name('sec.cree.pat');

    Route::get('/secretaire/rendez-vous Patient','RdvController@afficherListeRdv')->name('sec.afficher.rdv');


   

    Route::get('/secretaire/cree rdv patient','RdvController@afficherPriseRdv')->name('sec.afficher.prendre.rdv');
    Route::post('/secretaire/cree rdv patient','gCalendarController@secCreeRdv')->name('sec.cree.rdv');

    Route::get('/secretaire/annulerRdv/{id?}','gCalendarController@secAnnulerRdv')->name('sec.annuler.rdv');
    Route::get('/secretaire/presentRdv/{id?}','gCalendarController@secPresentRdv')->name('sec.present.rdv');
    Route::get('/secretaire/absentRdv/{id?}','gCalendarController@secAbsentRdv')->name('sec.absent.rdv');
    



    Route::get('/secretaire/historique des rendez-vous','RdvController@historiqueRdv')->name('sec.historique.rdv');



    Route::get('/secretaire/liste patient','PatientController@secListePatient')->name('sec.afficher.liste.patient');
    Route::get('/secretaire/liste patient en attente','PatientController@listePatientAttente')->name('sec.patient.attente');
    Route::get('/secretaire/confirmer inscription{id?}','PatientController@confirmerInscription')->name('sec.confirmer.inscription');

    Route::post('secretaire/heureDispo','gCalendarController@heureDispo')->name('sec.heureDispo'); 


    Route::get('secretaire/agenda','RdvController@secAgenda')->name('sec.agenda');

});

Route::post('rdvFiltreJour','RdvController@listeRdvJour')->name('rdv.jour');
Route::post('rdvFiltreSemaine','RdvController@listeRdvSemaine')->name('rdv.semaine');
Route::post('rdvFiltreMois','RdvController@listeRdvMois')->name('rdv.mois');

Route::get('imprimerRdv/{id?}','gCalendarController@secImprimerRdv')->name('imprimer.rdv');

Route::get('conditions generale',function(){
    return view('conditionGenerale');
})->name('cond.gene');








