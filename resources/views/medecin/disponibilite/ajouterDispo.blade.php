@extends('layouts.medecin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Formulaire d\'ajout d\'un événement') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('med.creer.dispo') }}">
                        @csrf


                        
                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">{{ __('Details') }}</label>

                            <div class="col-md-6">
                                <input id="details"  class="form-control" name="details" autofocus value="{{ old('details') }}" required autocomplete="details"> 

                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="dateDebut" class="col-md-4 col-form-label text-md-right">{{ __('Date de début') }}</label>

                            <div class="col-md-6">
                                <input id="dateDebut" type="datetime-local" class="form-control @error('dateDebut') is-invalid @enderror" name="dateDebut" value="{{ old('dateDebut') }}" required autocomplete="dateDebut" autofocus>

                                @error('dateDebut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dateFin" class="col-md-4 col-form-label text-md-right">{{ __('Date de fin') }}</label>

                            <div class="col-md-6">
                                <input id="dateFin" type="datetime-local" class="form-control @error('dateDebut') is-invalid @enderror" name="dateFin" value="{{ old('dateFin') }}" required autocomplete="dateFin" autofocus>

                                @error('dateFin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>



                        


                                

                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Ajouter événement
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