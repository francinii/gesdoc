@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/delete.js') }}" defer></script>
<script src="{{ asset('../resources/js/users.js') }}" defer></script>

@endsection
@section('title', 'Usuarios')
@section('header')
@include('layouts.header') 
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">Usuarios del sistema</h2>                      
   </div>    
   <div class="row  justify-content-center"> 
        <div class="col-md-10 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearDescription()" data-target="#create">
                <i class="fas fa-plus-circle"></i>   Agregar Usuario
            </button>  
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-10">
            @include('users.table')
        </div>
    </div> 
</div>
@include('users.create');
@include('users.edit');
