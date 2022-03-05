@extends('layouts.medecin')

@section('content')
        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif
    
    <div class="table-responsive w-100 mt-2 float-right">
    <div class="mb-3">
        <button class="btn btn-primary" id="jour" value="jour">Jour</button>
        <button class="btn btn-primary" id="semaine" value="semaine">Semaine</button>
        <button class="btn btn-primary" id="mois" value="mois">Mois</button>
    </div>
    
    <table class="table table-striped" id="table">
        <thead>
            <th>Date et heure du rendez-vous</th>
            <th>Nom du patient</th>
            <th>Numéro de registre national</th>
            <th></th>
            
        </thead>

        <tbody id="tbody">
            @foreach(Auth::guard('medecin')->user()->rdv->where('statut','actif')->where('dateRdv','>=',date('Y-m-d')) as $rdv)
                <tr>
                    <td>{{$rdv->dateFormat()}}</td>
                    <td>{{$rdv->patient->nom}}</td>
                    <td><a href="dossierMed/{{$rdv->patient->id}}">{{$rdv->patient->rn}}</a> </td>
                   
                    <td>
                        <a href="{{route('med.annuler.rdv',['id'=>$rdv->id])}}"><button class="btn-sm btn-danger" title="annuler"><i class="fas fa-trash"></i></button></a>
                        <a href="{{route('imprimer.rdv',['id'=>$rdv->id])}} "><button class="btn-sm btn-primary" title="imprimer"><i class="fas fa-print"></i></button></a>

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
                      dataTable.row.add([dateRdv,item.patient.nom,"<a href='dossierMed/"+item.patient.id+"'>"+item.patient.rn+"</a>","<a href='{{ route('med.annuler.rdv')}}/"+item.id+"'><button class='btn-sm btn-danger'><i class='fas fa-trash'></i></button></a> <a href='{{ route('imprimer.rdv')}}/"+item.id+"'><button class='btn-sm btn-primary'><i class='fas fa-print'></i></button></a>"]).draw();  
                       
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
                      dataTable.row.add([dateRdv,item.patient.nom,"<a href='dossierMed/"+item.patient.id+"'>"+item.patient.rn+"</a>","<a href='{{ route('med.annuler.rdv')}}/"+item.id+"'><button class='btn-sm btn-danger'><i class='fas fa-trash'></i></button></a> <a href='{{ route('imprimer.rdv')}}/"+item.id+"'><button class='btn-sm btn-primary'><i class='fas fa-print'></i></button></a>"]).draw();  
                       
                        
                        
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
                        dataTable.row.add([dateRdv,item.patient.nom,"<a href='dossierMed/"+item.patient.id+"'>"+item.patient.rn+"</a>","<a href='{{ route('med.annuler.rdv')}}/"+item.id+"'><button class='btn-sm btn-danger'><i class='fas fa-trash'></i></button></a> <a href='{{ route('imprimer.rdv')}}/"+item.id+"' ><button class='btn-sm btn-primary'><i class='fas fa-print'></i></button></a>"]).draw();  
                      
                        
                        
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