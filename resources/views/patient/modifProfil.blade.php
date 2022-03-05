@extends('layouts.patient')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Profil') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('modifProfil') }}">
                        @csrf


                        <input type="hidden" value="{{Auth::guard('patient')->user()->id}}" name="id">
                        <div class="form-group row">
                            <label for="rn" class="col-md-4 col-form-label text-md-right">{{ __('Numéro de registre national') }}</label>

                            <div class="col-md-6">
                                <input id="rn" type="text" class="form-control @error('rn') is-invalid @enderror" name="rn" value="{{Auth::guard('patient')->user()->rn}}" required autocomplete="rn" autofocus disabled>

                                @error('rn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nom') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{Auth::guard('patient')->user()->nom}}" required autocomplete="name" autofocus disabled>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prenom" class="col-md-4 col-form-label text-md-right">{{ __('Prénom') }}</label>

                            <div class="col-md-6">
                                <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom" value="{{ Auth::guard('patient')->user()->prenom }}" required autocomplete="prenom" autofocus disabled>

                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="date_naiss" class="col-md-4 col-form-label text-md-right">{{ __('Date de naissance') }}</label>

                            <div class="col-md-6">
                                <input id="date_naiss" type="date" class="form-control @error('date_naiss') is-invalid @enderror" name="date_naiss" value="{{ Auth::guard('patient')->user()->date_naiss }}" required autocomplete="date_naiss" autofocus disabled>

                                @error('prenom')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>




                        <div class="form-group row">
                            <label for="adresse" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</label>

                            <div class="col-md-6">
                                <input id="adresse" type="text" class="form-control @error('adresse') is-invalid @enderror" name="adresse" value="{{Auth::guard('patient')->user()->adresse}}" required autocomplete="adresse" autofocus>

                                @error('adresse')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>





                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ Auth::guard('patient')->user()->email }}" required autocomplete="email" disabled>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tel" class="col-md-4 col-form-label text-md-right">{{ __('Numéro de téléphone') }}</label>

                            <div class="col-md-6">
                                <input id="tel" type="tel" class="form-control @error('tel') is-invalid @enderror" name="tel" value="{{ Auth::guard('patient')->user()->tel }}" required autocomplete="tel">

                                @error('tel')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


	                    <div class="form-group row">
						  <label for="sexe" class="col-md-4 col-form-label text-md-right">Sexe</label>
						    <div class="col-md-6">
                                <p>{{Auth::guard('patient')->user()->sexe}}</p>
							</div>
						</div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Modifier
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