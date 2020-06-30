@extends('layouts.template')

@section('head')
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
            <h2 class="text-center">Historial de acciones</h2>                      
        </div>    
        <div class="row  justify-content-center"> 
            
            <div  class="col-md-12">&nbsp</div>
            <div class="col-9">
                @include('partials.alert')
                @include('historial.table')                
            </div>
        </div> 
    </div>
    @include('partials.alertModal')


    <script src="{{ asset('../resources/js/historial.js') }}" defer></script>
@stop