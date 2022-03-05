@extends('layouts.medecin')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Formulaire Radio') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ajouter.radio') }}" enctype="multipart/form-data">
                        @csrf


                        <input type="hidden" name="id_patient" value="{{$patient}}">
                        <div class="form-group row">
                            <label for="details" class="col-md-4 col-form-label text-md-right">{{ __('Détail') }}</label>

                            <div class="col-md-6">
                            <input id="details" type="text" class="form-control @error('details') is-invalid @enderror" name="details" value="{{ old('details') }}" required autocomplete="details" autofocus>

                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <label for="fichier" class="col-md-4 col-form-label text-md-right">{{ __('Fichier') }}</label>

                            <div class="col-md-6">
                            <input id="fichier" type="file" class="form-control @error('fichier') is-invalid @enderror" name="fichier" value="{{ old('fichier') }}" required autocomplete="fichier" autofocus>

                                @error('fichier')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Ajouter la radio
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