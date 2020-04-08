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
        <div class="col-md-10 editorCKEDITOR">
            <div data-editor="DecoupledDocumentEditor" data-collaboration="false">
                <div class="centered">
                    <div class="row">
                        <div class="document-editor__toolbar"></div>
                    </div>
                    <div class="row row-editor">
                        <div class="editor">

                        </div>
                    </div></div>
                </div>

            </div>
        </div>
        </div>
    </div>
</div>
@stop
