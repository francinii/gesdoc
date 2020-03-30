@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/documents.js') }}" defer></script>
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
@stop

@section('title', 'Documentos')
@section('header')
@include('layouts.header') 
@stop
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">{{ __('app.documents.index.title') }}</h2>                      
   </div>    
   <div class="row  justify-content-center"> 
        <div class="col-md-8 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearDescription()" data-target="#create">
                <i class="fas fa-plus-circle"></i>  {{ __('app.buttons.add') }}
            </button>    
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-8">
            @include('partials.alert')
            @include('documents.table')
        </div>
    </div> 
</div>

@include('documents.create')
@include('documents.edit')
@include('partials.confirm')
@stop


