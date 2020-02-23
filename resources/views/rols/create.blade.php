@extends('layouts.template')

@section('title', 'Crear Rol')


@section('header')
    @include('layouts.header') 


@section('content')
<div class="container">
    <br> 
      <h2 class="text-center">Nuevo Rol</h2>
    <br>    
    <form action="{{ action('RolController@index') }}" method="POST">
     {{csrf_field()}}
     
      <div class="form-group">
        <label for="rol">Nombre del rol</label>
        <input type="text" class="form-control" id="rol" placeholder="Nombre del rol" name="description">
      </div>      
      <button type="submit" class="btn btn-success">Agregar</button>
    </form>
</div>
