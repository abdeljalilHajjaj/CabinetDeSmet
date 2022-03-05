@extends('layouts.medecin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{'Antécédent de : '.' '.$antecedent->dossierMed->patient->prenom}}</div>
                
               
                <div class="card-body">
                        <div class="form-group mt-2 ">
                            <label class="form-label ml-3">Description</label>

                            <div class="col-md-12">
                                <textarea class="form-control w-100" rows="5">{{$antecedent->description}}</textarea>

                               
                            </div>
                        </div>  


                        <div class="form-group mt-2 ">
                            <label class="form-label ml-3">Date</label>

                            <div class="col-md-12">
                                <textarea class="form-control w-100" rows="1">{{$antecedent->created_at->format('d-m-Y H:i:s')}}</textarea>

                               
                            </div>
                        </div>  

                        <div class="form-group mt-2 ">
                            <label class="form-label ml-3">Inami médecin</label>

                            <div class="col-md-12">
                                <textarea class="form-control w-100" rows="1">{{$antecedent->inami_med}}</textarea>

                               
                            </div>
                        </div>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection