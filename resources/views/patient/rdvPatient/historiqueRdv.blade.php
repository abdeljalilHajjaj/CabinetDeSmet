@extends('layouts.patient')

@section('content')
<div class="table-responsive w-100 float-right">
            <table class="table" id="table">
                <thead>
                    <th>Date et heure du rendez-vous</th>
                    <th>Date de prise du rendez-vous</th>
                    <th>Medecin</th>
                    <th>Lieu</th>
                    
                </thead>
                <tbody>
                    
                    @foreach(Auth::guard('patient')->user()->rdv->where('statut','!=','actif') as $rdv)
                    
                        <tr>
                            <td>{{$rdv->dateFormat()}} </td>
                            <td>{{$rdv->created_at->format('d/m/Y H:i')}} </td>
                            <td>Dr {{$rdv->medecin->nom}} </td>
                            <td>Rue des trois gardes 344 schaerbeek</td>
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