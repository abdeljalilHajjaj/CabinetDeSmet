@extends('layouts.medecin')

@section('content')

        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif

    <div class="table table-responsive w-100  h-75 float-right">
        <div class="mb-3"><a  href="{{route('med.form.dispo')}} "> <button class="btn-sm btn-primary">Ajouter un événement</button> </a></div> 
        <table class="table" id="myTable">
            <thead>
                <th>Détails</th>
                <th>Date de debut</th>
                <th>Date de fin</th>
                <th></th>
            </thead>

            <tbody>
                @foreach(Auth::guard('medecin')->user()->disponibilite->where('statut','actif') as $dispo)
                    <tr>
                            <td>{{$dispo->details}}</td>
                            <td>{{$dispo->dateFormat()}}</td>
                            <td>{{$dispo->dateFinFormat()}}</td>
                            <td>
                                <a href="{{route('med.supp.dispo',['id'=>$dispo->id])}} "><button class="btn btn-danger"><i class="fas fa-trash"></i> </button></a>
                               
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
    $('#myTable').DataTable({
        "language": {
            "url": "{{asset('frDataTables.txt')}} "
        }
    });
} );
</script>

@endsection