@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/rols/edit.js') }}" defer></script>
<script src="{{ asset('../resources/js/modal.js') }}" defer></script>

@endsection
@section('title', 'Roles')
@section('header')
@include('layouts.header') 


@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">Listado de roles del sistema</h2>             
   </div>    
   <div class="row  justify-content-center">              
       <div class="justify-content-center "> 
        <div class="col-md-12 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearDescription()" data-target="#create">Agregar</button>
            <br> 
        </div>  
 
        @include('rols.table')
       </div>
     
   </div>
 
</div>

@include('rols.create')
@include('rols.edit')
