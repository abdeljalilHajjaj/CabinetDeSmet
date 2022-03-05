@extends('layouts.medecin')

@section('content')

        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Ajouter un nouveau rendez-vous</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('med.cree.rdv') }}">
                            @csrf



                            <div class="form-group row">
                                <label for="rn" class="col-md-4 col-form-label text-md-right">{{ __('Numéro de registre national') }}</label>

                                <div class="col-md-6">
                                <input list="test" name="rn">
                                   <datalist  id="test">
                                       @foreach($patients->where('statut','actif') as $patient)
                                            <option value="{{$patient->rn}}"> {{$patient->nom}} : {{$patient->rn}} </option>
                                       @endforeach
                                   </datalist>

                                    @error('rn')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>


                            


                            <div class="form-group row">
                                <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date du rendez-vous') }}</label>
                                <div class="col-md-6">
                                    <input type="text" name="date" value="choisir date" id="available_date" data-date-format="yyyy-mm-dd"> 
                                </div>
                                 @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>



                            <div class="form-group row">
                                <label for="adresse" class="col-md-4 col-form-label text-md-right">{{ __('Heure du rendez-vous') }}</label>
                                <div class="col-md-6">
                                <select id='available_times' name="heure">

                                </select>
                                </div>
                                
                            </div>



                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" id="submit" class="btn btn-primary">
                                        Ajouter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script>
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
           
              $(document).ready(function() {
               

                    $('#available_date').datepicker({
                        format: 'dd-mm-yyyy',
                        language: 'fr',
                        daysOfWeekDisabled: [0,6],
                        startDate:"{{date('d-m-Y')}}",
                        endDate: "{{$date->format('d-m-Y')}} "
                    });
                    $('#available_date').on('change', function() { 
                        var date = $('#available_date').val();
                        
                        $.post({
                            type: "POST",
                            url: "{{route('med.heureDispo')}}",
                            data:{'date':date},
                            
                            success:function(data){
                               
                                if($.isEmptyObject(data)){
                                    document.getElementById('submit').disabled = true;
                                    document.getElementById('available_times').innerHTML = 	'<option value="">Pas d\'heure disponible</option>';
                                
                                }
                                if(!$.isEmptyObject(data)){
                                    document.getElementById('submit').disabled = false;
                                    document.getElementById('available_times').innerHTML = data;
                                }
                            },
                            fail:function(data){
                                console.log(data);
                            }
                        });


                    });
                    $('#medecin').on('change', function(){
                        var date = $('#available_date').val();
                      
                        $.post({
                            type: "POST",
                            url: "{{route('med.heureDispo')}}",
                            data:{'date':date},
                            
                            success:function(data){

                                if($.isEmptyObject(data)){
                                    document.getElementById('submit').disabled = true;
                                    document.getElementById('available_times').innerHTML = 	'<option value="">Pas d\'heure disponible</option>';
                                
                                }
                                if(!$.isEmptyObject(data)){
                                    document.getElementById('submit').disabled = false;
                                    document.getElementById('available_times').innerHTML = data;
                                }
                            },
                            fail:function(data){
                                console.log(data);
                            }
                        });
                    });

                        


                  });

				  
                   

                
			
  

             
          </script>

@endsection