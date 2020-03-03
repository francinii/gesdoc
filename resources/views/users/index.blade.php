@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/delete.js') }}" defer></script>

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
        
        <a type="button" class=" float-right btn btn-success"  href="{{  route('register') }}" >    
                <i class="fas fa-plus-circle"></i> 
                Agregar Usuario
        </a>
            
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-10">
            @include('users.table')
        </div>
    </div> 
</div>


