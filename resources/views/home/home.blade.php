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

<div class="page-content" id="content">
<div class="container-fluid">
    <input type="hidden" id = "docType">
    <div class="row ">
        <div class="col-md-2">
            <div class="">               
                <div class="">
                    <div class="btn-group-vertical"> 
                        <button type="button" class="btn btn-dark btn-block "><i class="" aria-hidden="true"></i> Documentos </button>
                        
                        <button id = "btnCreateDocument" type="button" class="btn btn-light btn-block " onclick="newDocument(this)" ><i class="fa fa-plus" aria-hidden="true"></i> Agregar </button>
                        <button type="button" class="btn btn-light btn-bloc " onclick="createDoc(0)" ><i class="fa fa-upload" aria-hidden="true"></i>Importar Documento</button>        
                        <button type="button" class="btn btn-light btn-block" onclick="openSheet(1)">{{ __('app.home.menu.option1') }}</button>
                        <button type="button" class="btn btn-light btn-block" onclick="openSheet(2)">{{ __('app.home.menu.option2') }}</button>
                        <button type="button" class="btn btn-light btn-block" onclick="openSheet(3)">{{ __('app.home.menu.option3') }}</button>                
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
        <button id="createClassification" class="btn btn-link dropdown-item" onclick="createDoc(3)" ><i class="fas fa-plus-circle"></i> Crear Clasificación</button>
    </div>
</div>
@include('home.contextMenu')
@include('home.create')
@include('documents.create')
@include('documents.upload')
@include('home.edit')
@include('home.share')
@include('partials.alertModal')
@include('partials.search')
@include('partials.confirm')
</div>
@stop