@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/flujos.js') }}" defer></script>
<script src="{{ asset('../resources/js/delete.js') }}" defer></script>


@endsection
@section('title', 'Flujos')
@section('header')
@include('layouts.header') 
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">Flujos del sistema</h2>                      
   </div>    
   <div class="row  justify-content-center"> 
        <div class="col-md-8 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearDescription()" data-target="#create">
                <i class="fas fa-plus-circle"></i>   Agregar
            </button>    
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-8">
            @include('flujos.table')
        </div>
    </div> 
</div>

@include('flujos.create')
@include('flujos.edit')


