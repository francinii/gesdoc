@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/home.js') }}" defer></script>
<script src="{{ asset('../resources/js/documents.js') }}" defer></script>
@stop

@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-2">
            <div class="">               
                <div class="">
                    <div class="list-group">  
                        <button id = "btnCreateDocument" type="button" class="btn btn-success btn-block " onclick="newDocument(this)" ><i class="fa fa-plus" aria-hidden="true"></i> Agregar </button>
                         <input type="file" id="file" /> <label for="file" class="btn-3 btn-info btn-block"> <i class="fa fa-upload"> </i> Importar documento</label>          
                        <button type="button" class="btn btn-primary btn-block" onclick="openSheet(1)">{{ __('app.home.menu.option1') }}</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="openSheet(2)">{{ __('app.home.menu.option2') }}</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="openSheet(3)">{{ __('app.home.menu.option3') }}</button>                
                    </div>         
                </div>
            </div> 
        </div>

        <div class="col-md-10">
        @include('partials.alert')
                   
                  
        <div id="divTable">
            @include('home.tableMyDocuments')
        </div>
        </div>
    </div>

    <div class="dropdown-menu dropdown-menu-sm"  id="context-menu-create"  >
        <button id="createTxt" class="btn btn-link dropdown-item" onclick="createDoc(1)" ><i class="fas fa-plus-circle"></i> Crear documento</button>
        <button id="createSheet" class="btn btn-link dropdown-item" onclick="createDoc(2)" ><i class="fas fa-plus-circle"></i> Crear hoja de cálculo</button>
        <button id="createSheet" class="btn btn-link dropdown-item" onclick="createDoc(3)" ><i class="fas fa-plus-circle"></i> Crear Carpeta</button>
  
    </div>
</div>
@include('home.contextMenu')
@include('home.create')
@include('documents.create')
@include('home.edit')
@include('home.share')
@include('partials.alertModal')
@include('partials.search')
@include('partials.confirm')

@stop