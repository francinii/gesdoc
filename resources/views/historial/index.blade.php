@extends('layouts.template')

@section('head')
    <link rel="stylesheet"    href="{{ asset('../resources/css/advancedSearch.css') }}">
    <script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
        <!-- Para el select con search -->
@stop

@section('title', 'Historial') 

@section('header')
    @include('layouts.header') 
@stop
@section('content')
    <div class="container-fluid" id = "flow-wrapper">
        <div class="row  justify-content-center">         
            <h2 class="text-center">{{ __('app.record.index.title') }}</h2>                      
        </div>    
        <div class="row  justify-content-center"> 
            
            <div  class="col-md-12">&nbsp</div>
            <div class="col-md-11">
                    @include('historial.advancedSearch')  
                </div>
            <div class="col-11">
                @include('partials.alert')
                @include('historial.table')                
            </div>
        </div> 
    </div>
    @include('partials.alertModal')


    <script src="{{ asset('../resources/js/historial.js') }}" defer></script>
@stop