@extends('layouts.medecin')

@section('content')

        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif
    <div class="table-responsive  w-100 float-right"> 
        <table class="table table-striped table-inverse" id="myTable">
            <thead class="thead-inverse">
                <tr>
                    
                    <th>NISS</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Adresse</th>
                    <th>Date de naissance</th>
                    <th>Sexe</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($patients->where('statut','actif') as $patient)
                    @if($patient->rdv->where('statut','absent')->count() >10)
                    <tr style="color:white;background-color: red;">
                      
                        <td><a href="dossierMed/{{$patient->id}} ">{{$patient->rn}}</a></td>
                        <td>{{$patient->nom}}</td>
                        <td>{{$patient->prenom}}</td>
                        <td>{{$patient->adresse}}</td>
                        <td>{{$patient->dateFormat()}}</td>
                        <td>{{$patient->sexe}}</td>
                    </tr>
                    @else
                  

                    <tr>
                
                        <td><a href="dossierMed/{{$patient->id}} ">{{$patient->rn}}</a></td>
                        <td>{{$patient->nom}}</td>
                        <td>{{$patient->prenom}}</td>
                        <td>{{$patient->adresse}}</td>
                        <td>{{$patient->dateFormat()}}</td>
                        <td>{{$patient->sexe}}</td>
                    </tr>
                    @endif
                @endforeach
                </tbody>
        </table>
    </div>
	
@endsection

@section('js')

<script>
$(document).ready( function () {
    $('#myTable').DataTable({
        "language": {
            "url": "{{asset('frDataTables.txt')}} "
        }
    });
} );
</script>

@endsection