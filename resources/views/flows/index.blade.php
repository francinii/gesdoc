@extends('layouts.template')

@section('head')
    <script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
    <script src="{{ asset('../resources/extensions/leaderline/leader-line.min.js') }}"></script>      
    <script src="{{ asset('../resources/extensions/dragdrop/plain-draggable.min.js') }}"></script>   

        <!-- Para el select con search -->
@stop

@section('title', 'Flujos') 

@section('header')
    @include('layouts.header') 
@stop
@section('content')
    <?php $id = 2 ?>
    <div class="container-fluid" id = "flow-wrapper">
        <div class="row  justify-content-center">         
            <h2 class="text-center">{{ __('app.flows.index.title') }}</h2>                      
        </div>    
        <div class="row  justify-content-center"> 
            <div class="col-md-9 text-right">
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="openCreate(0)" data-target="">
                    <i class="fas fa-plus-circle"></i> {{ __('app.buttons.add') }}
                </button>    
            </div>
            <div  class="col-md-12">&nbsp;</div>
            <div class="col-9">
                @include('partials.alert')
                @include('flows.table')                
            </div>
        </div> 
    </div>
    @include('partials.alertModal')
    @include('flows.edit')
    @include('flows.list')
    @include('flows.card') 
    @include('partials.confirm')
    @include('flows.create')
    @include('flows.line')
   
    <div id="permissionModal">

    </div>


    <script src="{{ asset('../resources/js/flows.js') }}" defer></script>
@stop