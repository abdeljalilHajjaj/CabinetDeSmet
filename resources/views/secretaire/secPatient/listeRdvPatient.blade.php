@extends('layouts.secretaire')

@section('content')
        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif
    <h1 class="text-center mb-5">Rendez-vous en cours</h1>
    <div class="table-responsive w-100 mt-2 float-right">
    <div class="mb-3">
        <button class="btn btn-primary" id="jour" value="jour">Jour</button>
        <button class="btn btn-primary" id="semaine" value="semaine">Semaine</button>
        <button class="btn btn-primary" id="mois" value="mois">Mois</button>
    </div>
    
    <table class="table" id="table">
        <thead>
            <th>Date et heure du rendez-vous</th>
            <th> Nom du patient</th>
            <th> Numéro de registre national</th>
            <th>Medecin</th>
            <th></th>
            
        </thead>

        <tbody id="tbody">
            @foreach($rdvs->where('statut','actif') as $rdv)
                <tr>
                    <td>{{$rdv->dateFormat()}}</td>
                    <td>{{$rdv->patient->nom}}</td>
                    <td>{{$rdv->patient->rn}}</td>
                    <td>Dr. {{$rdv->medecin->nom}}</td>
                    <td>
                       
                        <a href="{{route('sec.present.rdv',['id'=>$rdv->id])}} "><button class="btn-sm btn-primary" title="présent"><i class="fas fa-check-circle"></i></button></a>
                        <a href="{{route('sec.absent.rdv',['id'=>$rdv->id])}} "><button class="btn-sm btn-danger" title="absent"><i class="fas fa-times"></i></button></a>
                        <a href="{{route('imprimer.rdv',['id'=>$rdv->id])}} "><button class="btn-sm btn-warning" title="imprimer"><i class="fas fa-print"></i></button></a>
                        <a href="{{route('sec.annuler.rdv',['id'=>$rdv->id])}}"><button class="btn-sm btn-dark" title="annuler"><i class="fas fa-trash"></i></button></a>
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
    
    

    $.ajaxSetup({
         headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
     });

     $('#jour').on('click', function() { 
        var jour = $('#jour').val();
        var dataTable = $('#table').DataTable();
        $.post({
                type: "POST",
                url: "{{route('rdv.jour')}}",
                data:{'jour':jour},
                            
                success:function(data){
                    dataTable.clear().draw();

                    
                    $.each(data, function (i, item) {
                        var date = new Date(item.dateRdv);
                        var jour = date.getDate(); 
                        var mois = date.getMonth() + 1; 
                        var annee = date.getFullYear();
                        var heure = date.getHours();
                        var minutes = date.getMinutes();
                        if (jour < 10) { 
                            jour = '0' + jour; 
                        } 
                        if (mois < 10) { 
                            mois = '0' + mois; 
                        } 
                        if(heure<10){
                            heure = '0'+heure;
                        }
                        if(minutes<10){
                            minutes = '0'+minutes;
                        }
                        var dateRdv = jour + '/' + mois + '/' + annee+' '+heure+':'+minutes; 
                        console.log(date);
                      dataTable.row.add([dateRdv,item.patient.nom,item.patient.rn,'Dr. '+item.medecin.nom,"<a href='{{ route('sec.present.rdv')}}/"+item.id+"' ><button class='btn-sm btn-primary'><i class='fas fa-check-circle'></i></button></a> <a href='{{ route('sec.absent.rdv')}}/"+item.id+"'><button class='btn-sm btn-danger'><i class='fas fa-times'></i></button></a> <a href='{{ route('imprimer.rdv')}}/"+item.id+"'><button class='btn-sm btn-warning'><i class='fas fa-print'></i></button></a><a href='{{ route('sec.annuler.rdv')}}/"+item.id+"'><button class='btn-sm btn-dark'><i class='fas fa-trash'></i></button></a>"]).draw();  
                       
                    });   
                },
                fail:function(data)
                    {
                    console.log(data);
                    }
                });
     });

     $('#semaine').on('click', function() { 
        var dataTable = $('#table').DataTable();
        var semaine = $('#semaine').val();
        
        $.post({
                type: "POST",
                url: "{{route('rdv.semaine')}}",
                data:{'semaine':semaine},
                            
                success:function(data){
                    dataTable.clear().draw();
                    console.log(data);
                    $.each(data, function (i, item) {
                        var date = new Date(item.dateRdv);
                        var jour = date.getDate(); 
                        var mois = date.getMonth() + 1; 
                        var annee = date.getFullYear();
                        var heure = date.getHours();
                        var minutes = date.getMinutes();
                        if (jour < 10) { 
                            jour = '0' + jour; 
                        } 
                        if (mois < 10) { 
                            mois = '0' + mois; 
                        } 
                        if(heure<10){
                            heure = '0'+heure;
                        }
                        if(minutes<10){
                            minutes = '0'+minutes;
                        }
                        var dateRdv = jour + '/' + mois + '/' + annee+' '+heure+':'+minutes; 
                      dataTable.row.add([dateRdv,item.patient.nom,item.patient.rn,'Dr. '+item.medecin.nom,"<a href='{{ route('sec.present.rdv')}}/"+item.id+"' ><button class='btn-sm btn-primary'><i class='fas fa-check-circle'></i></button></a> <a href='{{ route('sec.absent.rdv')}}/"+item.id+"'><button class='btn-sm btn-danger'><i class='fas fa-times'></i></button></a> <a href='{{ route('imprimer.rdv')}}/"+item.id+"'><button class='btn-sm btn-warning'><i class='fas fa-print'></i></button></a><a href='{{ route('sec.annuler.rdv')}}/"+item.id+"'><button class='btn-sm btn-dark'><i class='fas fa-trash'></i></button></a>"]).draw();  
                       
                        
                        
                    });
                },
                fail:function(data)
                    {
                    console.log(data);
                    }
                });
     });

     $('#mois').on('click', function() { 
        var dataTable = $('#table').DataTable();
        var mois = $('#mois').val();
        
        $.post({
                type: "POST",
                url: "{{route('rdv.mois')}}",
                data:{'mois':mois},
                            
                success:function(data){
                    dataTable.clear().draw();
                    console.log(data);
                    $.each(data, function (i, item) {
                        var date = new Date(item.dateRdv);
                        var jour = date.getDate(); 
                        var mois = date.getMonth() + 1; 
                        var annee = date.getFullYear();
                        var heure = date.getHours();
                        var minutes = date.getMinutes();
                        if (jour < 10) { 
                            jour = '0' + jour; 
                        } 
                        if (mois < 10) { 
                            mois = '0' + mois; 
                        } 
                        if(heure<10){
                            heure = '0'+heure;
                        }
                        if(minutes<10){
                            minutes = '0'+minutes;
                        }
                        var dateRdv = jour + '/' + mois + '/' + annee+' '+heure+':'+minutes; 
                      dataTable.row.add([dateRdv,item.patient.nom,item.patient.rn,'Dr. '+item.medecin.nom,"<a href='{{ route('sec.present.rdv')}}/"+item.id+"' ><button class='btn-sm btn-primary'><i class='fas fa-check-circle'></i></button></a> <a href='{{ route('sec.absent.rdv')}}/"+item.id+"'><button class='btn-sm btn-danger'><i class='fas fa-times'></i></button></a> <a href='{{ route('imprimer.rdv')}}/"+item.id+"'><button class='btn-sm btn-warning'><i class='fas fa-print'></i></button></a><a href='{{ route('sec.annuler.rdv')}}/"+item.id+"'><button class='btn-sm btn-dark'><i class='fas fa-trash'></i></button></a>"]).draw();  
                       
                        
                        
                    });
                },
                fail:function(data)
                    {
                    console.log(data);
                    }
                });
     });
</script>
@endsection