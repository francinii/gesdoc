@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/roles.js') }}" defer></script>
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
@stop

@section('title', 'Roles')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">{{ __('app.roles.index.title') }}</h2>                      
   </div>    
   <div class="row  justify-content-center">     
        <div class="col-md-9 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearDescription()" data-target="#create">
                <i class="fas fa-plus-circle"></i>   {{ __('app.buttons.add') }}
            </button>    
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-9">
            @include('partials.alert')
            @include('roles.table')
        </div>
    </div> 
</div>

@include('roles.create')
@include('roles.edit')
@include('roles.list')
@include('partials.confirm')
@stop
