@extends('layouts.app');
<table class="table-responsive">
    <thead>       
        <tr>
            <th>Id</th>
            <th>Descripcion del Rol</th>            
        </tr>
    </thead>
    <tbody>
        @foreach ($rols as $rol)  
        <tr>
            <td class="">{{$rol->id}}</td>
            <td class="">{{$rol->description}}</td>      
        </tr>
        @endforeach
    </tbody>
</table>
