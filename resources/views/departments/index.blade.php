@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/departments.js') }}" defer></script>

@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">
        <h2 class="text-center">{{ __('app.departments.index.title') }}</h2>
   </div>
   <div class="row  justify-content-center">
        <div class="col-md-6">
            @include('partials.alert')
        </div>
        <div class="col-md-2 text-right">
            <button data-toggle="modal" class=" float-right btn btn-success" onclick="clearCreate()" data-target="#create">
                <i class="fas fa-plus-circle"></i>  {{ __('app.buttons.add') }}
            </button>
        </div>
        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-8">
            @include('departments.table')
        </div>
    </div>
</div>
@include('departments.create')
@include('departments.edit')

@include('partials.error')
@include('partials.search')
@include('partials.confirm')
@stop