@extends('layouts.patient')

@section('content')

        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif

        
        @if(session()->has('erreur'))
            <div class="alert alert-danger">
                {{ session()->get('erreur') }}
            </div>
        @endif

    <div class="table-responsive w-100 float-right">
            <table class="table" id="table">
                <thead>
                    <th>Date et heure du rendez-vous</th>
                    <th>Date de prise du rendez-vous</th>
                    <th>Medecin</th>
                    <th>Lieu</th>
                    <th></th>
                    
                </thead>
                <tbody>
                    
                    @foreach($rdvs->where('statut','actif')->where('dateRdv','>=',date('Y-m-d')) as $rdv)
                    
                        <tr>
                            <td>{{$rdv->dateFormat()}} </td>
                            <td>{{$rdv->created_at->format('d/m/Y H:i')}} </td>
                            <td>Dr {{$rdv->medecin->nom}} </td>
                            <td>Rue des trois gardes 344 schaerbeek</td>
                        
                            <td>
                            @if(($rdv->statut =='annuler') || ($rdv->statut == 'absent') || ($rdv->statut =='present'))

                                    
                                        
                                    @else
                            @if($rdv->unJourAvant()->format('Y-m-d H:i') < date('Y-m-d H:i'))
                                
                                    <button disabled="true">Annuler</button>
                        
                            
                            @else
                                    

                                            <a href="{{route('annuler.rdv.pat',['id' =>$rdv->id])}}" onClick="return confirm('Voulez-vous vraiment annuler votre rendez-vous?')" ><button>Annuler</button></a>
                                    @endif
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            
            </table>
    </div>    
    

@endsection

@section('js')
    <script>
         $(document).ready( function () {
            $('#table').DataTable({
                "language": {
                        "url": "{{asset('frDataTables.txt')}} "
                }
            });

        
        } );
    

    </script>
@endsection


