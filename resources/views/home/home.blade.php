@extends('layouts.template')

@section('head')
<link rel="stylesheet"    href="{{ asset('../resources/css/advancedSearch.css') }}">
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/home.js') }}" defer></script>
<script src="{{ asset('../resources/js/documents.js') }}" defer></script>

@stop

@section('title', 'Documentos')
@section('header')
@include('layouts.header')
@stop

@section('content')

<div class="page-content" id="content" >
<div class="container-fluid" >
    <input type="hidden" id = "docType">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-9 text-right">
            <button  class=" float-right btn btn-link" onclick="showAdvancedSearch(0)">
            <i class="fas fa-search"></i>  {{ __('app.home.index.advancedSearch') }}
            </button>
        </div> 
    </div>
    <div class="row" style="margin-bottom: 1%; ">   
        <div class="col-md-2"></div>            
        <div class="col-md-9">
            @include('home.advancedSearch')  
        </div>
    </div>
    <div class="row ">
        <div class="col-md-2">
            <div class="">
                <div class="">
                    <div class="btn-group-vertical">
                        <button type="button" class="btn btn-dark btn-block "><i class="" aria-hidden="true"></i> {{ __('app.home.menu.option4') }} </button>
                        <button id = "btnCreateDocument" type="button" class="btn btn-light btn-block " onclick="newDocument(this)" > <i class="fas fa-file-medical" aria-hidden="true"> </i> {{ __('app.home.menu.option5') }} </button>
                        <button type="button" class="btn btn-light btn-bloc " onclick="createDoc(0)" ><i class="fa fa-upload" aria-hidden="true"> </i> {{ __('app.home.menu.option6') }}</button>
                        <button type="button" class="btn btn-light btn-block" onclick="openSheet(1)"><i class="fa fa-folder-open" aria-hidden="true"></i> {{ __('app.home.menu.option1') }}</button>
                        <button type="button" class="btn btn-light btn-block" onclick="openSheet(2)"><i class="fa fa-file" aria-hidden="true"> </i> {{ __('app.home.menu.option2') }}</button>
                        <button type="button" class="btn btn-light btn-block" onclick="location.href='{{ url('userDocFlow') }}'" ><i class="fa fa-angle-double-right" aria-hidden="true"> </i> {{ __('app.home.menu.option3') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">            
            <div class="row">      
                <div class="col-md-12"> 
                @include('partials.alert')
                </div>   
            </div>
            <div class="row">
                <div id="divTable" class="table-responsive" >
                {{csrf_field()}}
                    @include('home.tableMyDocuments')
                </div>
            </div>
        </div>
        <div class="dropdown-menu dropdown-menu-sm"  id="context-menu-create"  >
            <button id="createTxt" class="btn btn-link dropdown-item" onclick="createDoc(1)" ><i class="fas fa-plus-circle"></i> Crear documento</button>
            <button id="createSheet" class="btn btn-link dropdown-item" onclick="createDoc(2)" ><i class="fas fa-plus-circle"></i> Crear hoja de cálculo</button>
            <button id="createClassification" class="btn btn-link dropdown-item" onclick="createDoc(3)" ><i class="fas fa-plus-circle"></i> Crear Clasificación</button>
            <button  class="btn btn-link dropdown-item" id="actionsMenu" disable><i class="fas fa-ban"></i> Sin acciones</button>
        </div>
    </div>
</div>
@include('home.contextMenu')
@include('home.create')
@include('documents.create')
@include('documents.upload')
@include('documents.edit')
@include('home.edit')
@include('home.share')
@include('partials.alertModal')
@include('partials.search')
@include('partials.confirm')
</div>
@stop
