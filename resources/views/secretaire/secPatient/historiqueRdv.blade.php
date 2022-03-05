@extends('layouts.secretaire')

@section('content')

<h1 class="text-center mb-5">Historique des rendez-vous</h1>
<div class="table-responsive w-100 mt-2 float-right">
<table class="table table-striped" id="table">
        <thead>
            <th>Date et heure du rendez-vous</th>
            <th> Nom du patient</th>
            <th> Numéro de registre national</th>
            <th>Medecin</th>
            <th>Statut</th>
            
        </thead>

        <tbody>
            @foreach($rdvs as $rdv)
                <tr>
                    <td>{{$rdv->dateFormat()}}</td>
                    <td>{{$rdv->patient->nom}}</td>
                    <td>{{$rdv->patient->rn}}</td>
                    <td>Dr. {{$rdv->medecin->nom}}</td>
                    <td>{{$rdv->statut}}</td>
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

                },
                "order": [[ 0, "desc" ]]
            });

       
        } );
    </script>
@endsection