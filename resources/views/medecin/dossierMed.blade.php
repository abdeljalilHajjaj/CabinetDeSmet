@extends('layouts.medecin')

@section('content')
    
<div><h2 class="text-center">Dossier : {{$dossier->patient->rn }}</h2></div>
<div class="container-fluid  float-right " style="width: 100vw;">
  <div class="row border border-dark " >
        <div class="col-sm-4 col-md-4 col-lg-4 border border-primary table-responsive">
              <table class="table" >
                  <thead>
                      <th> Nom </th>
                      <th> Prénom</th>
                      <th> Age </th>
                      <th> sexe </th>
                    </thead>
                  <tbody>
                    <tr>
                      <td> {{$dossier->patient->nom}}</td>
                      <td> {{$dossier->patient->prenom}}</td>
                      <td> {{$dossier->patient->getAge()}}</td>
                      <td> {{$dossier->patient->sexe}}</td>
                    </tr>

                  </tbody>
                
              </table>
        </div>
        <div class="col-sm-8 col-md-8 col-lg-8 border border-primary table-responsive" style="height:12vw">
          <p class="float-left">Antécédent</p>
          <button style="float: right;">
                  <a href="{{route('afficher.ajouter.antecedent',['id'=>$dossier->patient_id])}}">
                    Ajouter antécédent
                  </a
              ></button>
              <table class="table" >
                  <thead>
                    <th>Description</th>
                    <th class="w-25">Inami Médecin</th>
                    <th>Date</th>
                  </thead>

                  <tbody>

                       @foreach($dossier->antecedent->where('statut','actif')->sortByDesc('created_at') as $antecedent)
                        <tr>
                            <td >{{$antecedent->description}}</td>
                            <td >{{$antecedent->inami_med}} </td>
                            <td>{{$antecedent->updated_at->format('d/m/y H:i')}} </td>
                            <td>
                              <div class="btn-group ">
                                <a class="text-light" href="{{route('voir.antecedent',['id'=>$antecedent->id])}}"><button class="btn-sm btn-primary"><i class="fas fa-eye"></i></button></a>
                                <a class="text-light" href="{{route('afficher.modifier.antecedent',['id'=>$antecedent->id])}}"><button class="btn-sm btn-secondary"><i class="fas fa-pen"></i></button></a>
                                <a class="text-light" href="{{route('supp.antecedent',['id'=>$antecedent->id])}}" onclick="return confirm('Etes vous sur?')"><button class="btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                              </div>
                          </td>
                        </tr>
                       @endforeach
                  </tbody>
              </table>
        </div>


        
        
  </div>
      
      
      
  <div class="row mt-3" >
          <div class="col-sm border border-danger table-responsive" style="height:15vw;">
          <p class="float-left">Consultation</p>
          <button style="float: right;">
                  <a href="{{route('afficher.ajouter.consultation',['id'=>$dossier->patient_id])}}">
                    Ajouter consultation
                  </a
              ></button>
              <table class="table"  >
                  <thead>
                      <th>Motif</th>
                      <th>Taille</th>
                      <th>Poids</th>
                      <th>Temperature</th>
                      <th>Inami Médecin</th>
                      <th>Date</th>
                      
                      
                    </thead>
                  <tbody>
                    @foreach($dossier->consultation->where('statut','actif')->sortByDesc('created_at') as $consultation)
                      <tr>
                        <td> {{$consultation->motif}}</td>
                        <td> {{$consultation->taille}} Cm</td>
                        <td> {{$consultation->poids}} Kg</td>
                        <td> {{$consultation->temperature}} °C</td>
                        <td>{{$consultation->inami_med}} </td>
                        <td>{{$consultation->updated_at->format('d/m/y H:i')}} </td>
                        <td>
                              <div class="btn-group">
                                <a class="text-light" href="{{route('voir.consultation',['id'=>$consultation->id])}}"><button class="btn-sm btn-primary"><i class="fas fa-eye"></i></button></a>
                                <a class="text-light" href="{{route('afficher.modifier.consultation',['id'=>$consultation->id])}}"><button class="btn-sm btn-secondary"><i class="fas fa-pen"></i></button></a>
                                <a class="text-light" href="{{route('supp.consultation',['id'=>$consultation->id])}}" onclick="return confirm('Etes vous sur?')"><button class="btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                              </div>
                          </td>
                        
                        
                      </tr>
                    @endforeach
                  </tbody>
                
              </table>
        </div>
  </div>

  <div class="row  mt-3  " >
        <div class="col-sm-6 border border-primary table-responsive" style="height:15vw;">
            <p class="float-left">Radio</p>
                <button style="float: right;">
                   <a href="{{route('afficher.ajouter.radio',['id'=>$dossier->patient_id])}}">
                          Ajouter une radio
                   </a>
                </button>
              <table class="table">
                  <thead>
                      <th> Details </th>
                      <th> Inami Médecin</th>
                      <th> Date </th>
                    </thead>
                  <tbody>
                    @foreach($dossier->radio->where('statut','actif')->sortByDesc('created_at') as $radio)
                      <tr>
                        <td><a href="{{ route('afficher.radio',['lien'=>$radio->lien])}}" target="_blank">{{$radio->details}}</a> </td>
                        <td> {{$radio->inami_med}}</td>
                        <td> {{$radio->created_at->format('d/m/y H:i')}}</td>
                        
                        <td>
                              <div class="btn-group">
                              <a class="text-light" href="{{route('supp.radio',['id'=>$radio->id])}}" onclick="return confirm('Etes vous sur?')"> <button class="btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                              </div>
                       </td>

                       
                      </tr>
                    @endforeach
                  </tbody>
                
              </table>
        </div>



        <div class="col-sm-6 border border-primary table-responsive" style="height:15vw;">
            <p class="float-left">Analyse</p>
                <button style="float: right;">
                   <a href="{{route('afficher.ajouter.analyse',['id'=>$dossier->patient_id])}}">
                          Ajouter une analyse
                   </a>
                </button>
              <table class="table">
                  <thead>
                      <th> Type d'analyse </th>
                      <th> Inami Médecin </th>
                      <th> Date </th>
                    </thead>
                  <tbody>
                    @foreach($dossier->analyse->where('statut','actif')->sortByDesc('created_at') as $analyse)
                      <tr>
                        <td><a href="{{ route('afficher.analyse',['lien'=>$analyse->lienFichier])}}" target="_blank">{{$analyse->typeAnalyse}}</a> </td>
                        <td> {{$analyse->inami_med}}</td>
                        <td> {{$analyse->created_at->format('d/m/y H:i')}}</td>
                        <td>
                              <div class="btn-group">
                              <a class="text-light" href="{{route('supp.analyse',['id'=>$analyse->id])}}" onclick="return confirm('Etes vous sur?')"> <button class="btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                              </div>
                       </td>

                       
                      </tr>
                    @endforeach
                  </tbody>
                
              </table>
        </div>
        


        
        
  </div>

  <div class="row mt-3 mb-5" >
          <div class="col-sm-6 border border-danger table-responsive" style="height:15vw;">
          <p class="float-left">Ordonnances</p>
          <button style="float: right;">
                  <a href="{{route('afficher.ajouter.ord',['id'=>$dossier->patient_id])}}">
                    Ajouter une ordonnance
                  </a
              ></button>
              <table class="table"  >
                  <thead>
                      <th>liste médicament</th>
                      <th>Inami Médecin</th>
                      <th>Date</th>
                    </thead>
                  <tbody>
                    @foreach($dossier->ordonnance->where('statut','actif')->sortByDesc('created_at') as $ord)
                      <tr>
                        <td>{{$ord->listeMedic}} </td>
                        <td>{{$ord->inami_med}} </td>
                        <td>{{$ord->updated_at->format('d/m/y H:i')}} </td>
                        <td>
                              <div class="btn-group">
                                <a class="text-light" href="{{route('voir.ordonnance',['id'=>$ord->id])}}"><button class="btn-sm btn-primary"><i class="fas fa-eye"></i></button></a>
                                <a class="text-light" href="{{route('supp.ordonnance',['id'=>$ord->id])}}" onclick="return confirm('Etes vous sur?')"><button class="btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                              </div>
                          </td>
                        
                        
                      </tr>
                    @endforeach
                  </tbody>
                
              </table>
        </div>

         <div class="col-sm-6 border border-danger table-responsive" style="height:15vw;">
          <p class="float-left">Facteur de risque</p>
          <button style="float: right;">
                  <a href="{{route('afficher.ajouter.facteur',['id'=>$dossier->patient_id])}}">
                    Ajouter un Facteur de risque
                  </a
              ></button>
              <table class="table">
                  <thead>
                      <th>Description</th>
                      <th>Date</th>
                      <th></th>
                    </thead>
                  <tbody>
                    @foreach($dossier->facteurRisque->where('statut','actif')->sortByDesc('created_at') as $fact)
                      <tr>
                        <td>{{$fact->description}} </td>
                        <td>{{$fact->updated_at->format('d/m/y H:i')}} </td>
                        <td>
                              
                              <div class="btn-group ">
                                <a class="text-light" href="{{route('voir.facteur',['id'=>$fact->id])}}"><button class="btn-sm btn-primary"><i class="fas fa-eye"></i></button></a>
                                <a class="text-light" href="{{route('afficher.modifier.facteur',['id'=>$fact->id])}}"><button class="btn-sm btn-secondary"><i class="fas fa-pen"></i></button></a>
                                <a class="text-light" href="{{route('supp.facteur',['id'=>$fact->id])}}" onclick="return confirm('Etes vous sur?')"><button class="btn-sm btn-danger"><i class="fas fa-trash"></i></button></a>
                             
                              </div>
                          </td>
                        
                        
                      </tr>
                    @endforeach
                  </tbody>
                
              </table>
        </div>

        
  </div>

  



  
    
</div>
      

@endsection



