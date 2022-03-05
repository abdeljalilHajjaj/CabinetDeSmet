@extends('layouts.medecin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Voir consultation') }}</div>

                <div class="card-body">


                       
                <div class="form-group row">
                            <label for="motif" class="col-md-4 col-form-label text-md-right">{{ __('Motif') }}</label>

                            <div class="col-md-6">
                                <textarea id="motif"  class="form-control" name="motif" autofocus rows="5">{{$consultation->motif}} </textarea>

                                @error('motif')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="objectif" class="col-md-4 col-form-label text-md-right">{{ __('Objectif') }}</label>

                            <div class="col-md-6">
                                <textarea id="objectif"  class="form-control" name="objectif" autofocus rows="5">{{$consultation->objectif}} </textarea>

                                @error('objectif')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="subjectif" class="col-md-4 col-form-label text-md-right">{{ __('Subjectif') }}</label>

                            <div class="col-md-6">
                                <textarea id="subjectif"  class="form-control" name="subjectif" autofocus rows="5">{{$consultation->subjectif}}</textarea>

                                @error('subjectif')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="poids" class="col-md-4 col-form-label text-md-right">{{ __('Poids(Kg)') }}</label>

                            <div class="col-md-6">
                                <input id="poids" type="number" class="form-control @error('poids') is-invalid @enderror" name="poids" value="{{$consultation->poids}}" required autocomplete="poids" autofocus  step="0.01">

                                @error('poids')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="taille" class="col-md-4 col-form-label text-md-right">{{ __('Taille(Cm)') }}</label>

                            <div class="col-md-6">
                                <input id="taille" type="number" class="form-control @error('taille') is-invalid @enderror" name="taille" value="{{$consultation->taille}}" required autocomplete="taille" autofocus >

                                @error('taille')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="sys" class="col-md-4 col-form-label text-md-right">{{ __('Pression artérielle systolique(cmHg)') }}</label>

                            <div class="col-md-6">
                                <input id="sys" type="number" class="form-control @error('sys') is-invalid @enderror" name="sys" value="{{$consultation->pa_sys}}" required autocomplete="sys" autofocus step="0.01" >

                                @error('sys')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="dia" class="col-md-4 col-form-label text-md-right">{{ __('Pression artérielle diastolique(cmHg)') }}</label>

                            <div class="col-md-6">
                                <input id="dia" type="number" class="form-control @error('dia') is-invalid @enderror" name="dia" value="{{$consultation->pa_dia}}" required autocomplete="dia" autofocus step="0.01" >

                                @error('dia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="rythme_card" class="col-md-4 col-form-label text-md-right">{{ __('Rythme Cardiaque') }}</label>

                            <div class="col-md-6">
                                <input id="rythme_card" type="number" class="form-control @error('rythme_card') is-invalid @enderror" name="rythme_card" value="{{$consultation->rythme_card}}" required autocomplete="rythme_card" autofocus step="0.01" >

                                @error('Rythme Cardiaque')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        <div class="form-group row">
                            <label for="saturation_oxygene" class="col-md-4 col-form-label text-md-right">{{ __('Saturation en oxygène(SPo2)') }}</label>

                            <div class="col-md-6">
                                <input id="saturation_oxygene" type="number" class="form-control @error('Saturation en oxygène') is-invalid @enderror" name="saturation_oxygene" value="{{$consultation->saturation_oxygene}}" required autocomplete="saturation_oxygene" autofocus step="0.01" >

                                @error('Saturation en oxygène')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="temperature" class="col-md-4 col-form-label text-md-right">{{ __('Température') }}</label>

                            <div class="col-md-6">
                                <input id="temperature" type="number" class="form-control @error('temperature') is-invalid @enderror" name="temperature" value="{{$consultation->temperature}}" required autocomplete="temperature" autofocus step="0.01" >

                                @error('temperature')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="plan" class="col-md-4 col-form-label text-md-right">{{ __('Plan de suivi') }}</label>

                            <div class="col-md-6">
                                <textarea id="plan"  class="form-control" name="plan" autofocus rows="5">{{$consultation->planSuivi}}</textarea>

                                @error('plan')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="inami" class="col-md-4 col-form-label text-md-right">{{ __('Inami médecin') }}</label>

                            <div class="col-md-6">
                                <input id="inami" type="text" class="form-control @error('inami') is-invalid @enderror" name="inami" value="{{$consultation->inami_med}}" required autocomplete="temperature" autofocus step="0.01" >
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">{{ __('Date') }}</label>

                            <div class="col-md-6">
                                <input id="date" type="text" class="form-control @error('date') is-invalid @enderror" name="date" value="{{$consultation->updated_at}}" required autocomplete="temperature" autofocus step="0.01" >
                            </div>
                        </div>


                                

                        
                       
                  
                </div>
            </div>
        </div>
    </div>
</div>


@endsection