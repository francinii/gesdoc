@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/users.js') }}" defer></script> 
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">{{ __('app.users.index.title') }}</h2>                      
   </div>    
   <div class="row  justify-content-center">        
        <div class="col-md-9 text-right">           
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearCreate()" data-target="#create">
                <i class="fas fa-plus-circle"></i>  {{ __('app.buttons.add') }}
            </button>  
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-9 ">
            @include('partials.alert')
            <div id="divTable" class="table-responsive" >
                @include('users.table')
            </div>
        </div>
    </div> 
</div>
@include('users.create')
@include('users.edit')

@include('partials.alertModal')
@include('partials.search')
@include('partials.confirm')
<script>
var ldap={{env("use_LDAP")}}
</script>

@stop

