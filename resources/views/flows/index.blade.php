@extends('layouts.template')

@section('head')

<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/flows.js') }}" defer></script>

@endsection
@section('title', 'Flujos')
@section('header')
@include('layouts.header') 
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">{{ __('app.flows.index.title') }}</h2>                      
   </div>    
   <div class="row  justify-content-center"> 
        <div class="col-md-8 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearDescription()" data-target="#create">
                <i class="fas fa-plus-circle"></i> {{ __('app.buttons.add') }}
            </button>    
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-8">
            @include('partials.alert')
            @include('flows.table')
        </div>
    </div> 
</div>

@include('flows.create')
@include('flows.edit')
@include('partials.confirm')


