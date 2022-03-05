@extends('layouts.patient')

@section('content')
    
        @if(session()->has('succes'))
            <div class="alert alert-success">
                {{ session()->get('succes') }}
            </div>
        @endif

        @if(session()->has('erreur'))
            <div class="alert alert-danger">
                {{ session()->get('erreur') }}
            </div>
        @endif


        

@endsection