@extends('layouts.secretaire')

@section('content')
    <h1 class="text-center mb-5">Liste des patients en attente</h1>
    <div class="table table-responsive w-100 float-right">
        <table class="table table-striped" id="table">
            <thead>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Numéro de registre national</th>
                <th>Adresse</th>
                <th>Tel</th>
                <th>date d'inscription</th>
                <th></th>
            </thead>

            <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{$patient->nom}} </td>
                        <td>{{$patient->prenom}} </td>
                        <td>{{$patient->rn}}</td>
                        <td>{{$patient->adresse}}</td>
                        <td>{{$patient->tel}}</td>
                        <td>{{$patient->created_at->format('d/m/Y H:i')}} </td>
                        <td>

                            <a href="{{route('sec.confirmer.inscription',['id'=>$patient->id ])}} "><button>Confirmer l'inscription </button></a>
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