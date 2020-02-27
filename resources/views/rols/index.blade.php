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
            <button data-toggle="modal" class=" float-right btn btn-success " data-target="#create">Agregar</button>
            <br> 
        </div>  
        <table class="table table-responsive table-striped">
            <thead class="thead-dark">      
                <tr>
                    <th>Id</th>
                    <th >Descripcion del Rol</th>  
                    <th>Modificar Rol</th>
                    <th>Eliminar Rol</th>          
                </tr>
            </thead>
            <tbody>
                @foreach ($rols as $rol)  
                <tr>
                    <td class="">{{$rol->id}}</td>
                    <td class="">{{$rol->description}}</td>
                    <td class="">                       
                            <button onclick = "edit('{{$rol->id}}', '{{$rol->description}}' )"  class="btn btn-info"  data-toggle="modal" class=" float-right btn btn-success " >Editar</button>              
                    </td>   
                    <td class="">
                        <form method="POST" action="{{url('/rols/'.$rol->id)}}">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                            <button type="submit" class=" btn btn-danger">Eliminar</button> 
                        </form>                         
                    </td>                                            
                </tr>
                @endforeach
            </tbody>
        </table>
       </div>
     
   </div>
 
</div>

@include('rols.create')
@include('rols.edit')
