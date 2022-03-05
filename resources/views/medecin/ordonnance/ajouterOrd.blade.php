@extends('layouts.medecin')



@section('css')
<link href="{{ asset('Drop-Down-Combo-Tree/style.css') }}" rel="stylesheet">
@endsection
@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Formulaire d\'ajout d\'une ordonnance') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ajouter.ord') }}">
                        @csrf

                        <input type="hidden" name="id_patient" value="{{$patient}}">
                        

                       

                        <div class="form-group row">
                            <label for="saturation_oxygene" class="col-md-4 col-form-label text-md-right">{{ __('Liste de médicaments') }}</label>

                            <div class="col-md-6">
                            <input type="text" name="list[]" id="example" class="form-control" placeholder="Choix" autocomplete="off" >

                               
                            </div>
                        </div>


                       


                                

                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Crée une ordonnance
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
    var myData = [

    @foreach($medicaments  as $medicament)
        {
            id:{{$medicament->id}},
            title: '{{$medicament->nomMedic}} '+': '+'{{$medicament->posologie}} '
        },
    @endforeach
  
   
];

$('#example').comboTree({
  source : myData,
  isMultiple: true
});
</script>

@endsection