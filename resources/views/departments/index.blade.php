@extends('layouts.template')

@section('head')


@endsection
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/departments.js') }}" defer></script> 
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">Departamentos del sistema</h2>                      
   </div>    
   <div class="row  justify-content-center"> 
        <div class="col-md-8 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearCreate()" data-target="#create">
                <i class="fas fa-plus-circle"></i>   Agregar Departamento
            </button>  
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-8">
            @include('departments.table')
        </div>
    </div> 
</div>
@include('departments.create')
@include('departments.edit')
@include('departments.confirmar')


