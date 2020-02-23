@extends('layouts.template')



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
            <button onclick="location.href = '{{ route('rols.create') }}'" class=" float-right btn btn-success ">Agregar</button>
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
                            <a class="btn btn-info" href="{{url('/rols/'.$rol->id.'/edit')}}">Modificar</a>              
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
