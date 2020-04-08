@extends('layouts.template')

@section('title', 'Editor')
@section('head')
<link rel="stylesheet"  href="{{ asset('../resources/css/textEditor.css') }}" >
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/decoupled-document/ckeditor.js"></script>

<script src="{{ asset('../resources/js/textEditor.js') }}" defer></script>
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
@stop
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">
        <div class="col-md-10">
                <div class="document-editor">
                    <div class="document-editor__toolbar"></div>
                    <div class="document-editor__editable-container">
                    <div class="document-editor__editable">
                        <p>The initial editor data.</p>
                    </div>
                </div>
        </div>
        </div>
    </div>
</div>



@stop
