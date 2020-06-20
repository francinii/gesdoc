@extends('layouts.template')

@section('title', 'Editor')
@section('head')

<link rel="stylesheet" type="text/css" href="{{ asset('../resources/extensions/CKEDITOR5/sample/styles.css') }}" >
<script src="{{ asset('../resources/extensions/CKEDITOR5/build/ckeditor.js') }}"></script>
<script src="{{ asset('../resources/js/textEditor.js') }}" defer></script>
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
@stop
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
   
   <div class="row  justify-content-center">   
    
    <div class="col-md-12 button-group">
        <div class="centered"> 
        <button  type="button" id="CreateSubmit" onclick="" class="btn btn-success ml-auto">
          <i class="fas fa-arrow-left"></i>
        </button> 
        <button type="button" class="btn btn-success float-right" onclick="">
            <i class="fa fa-save" aria-hidden="true"></i>
          Guardar
        </button>
        <button type="button" class="btn btn-danger float-right" onclick="">
          <i class="fa fa-download"> </i>
          Descargar
        </button>
        <button type="button" class="btn btn-info float-right" onclick="">
          <i class="fa fa-upload"> </i>
          Importar
        </button>
        <button type="button" class="btn btn-primary float-right" onclick="">
          <i class="fa fa-share-alt"> </i>
          Compartir
        </button> 
    </div>
    </div>         
        <div class="col-md-12 editorCKEDITOR">
            <div data-editor="DecoupledDocumentEditor" data-collaboration="false">
                <div class="centered">
                    <div class="">                       
                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class=" row-editor">
                        <div class="editor"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
