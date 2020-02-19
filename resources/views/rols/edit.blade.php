@extends('layouts.template')

@section('title', 'Crear Rol')
@section('header')
    @include('layouts.header') 


@section('content')
<div class="container">
    <br> 
      <h2 class="text-center">Editar Rol</h2>
    <br>    
    <form action="{{url('/rols/'.$rol->id)}}" method="POST">
     {{csrf_field()}}
     {{method_field('PATCH')}}
      <div class="form-group">
        <label for="rol">Nombre del rol</label>
        <input type="text" class="form-control" id="rol" placeholder="Nombre del rol" name="description" value="{{$rol->description}}">
      </div>      
      <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
