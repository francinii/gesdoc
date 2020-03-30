@extends('layouts.template')

@section('title', 'Editor')
@section('head')
<link rel="stylesheet"  href="{{ asset('../resources/css/textEditor.css') }}" >
<script src="https://cdn.ckeditor.com/4.8.0/full-all/ckeditor.js"></script>


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
            <textarea id="editor1">
           
            </textarea>
        </div>
    </div>
</div>



@stop
