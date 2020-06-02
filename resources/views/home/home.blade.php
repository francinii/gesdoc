@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/home.js') }}" defer></script>

@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-2">
            <div class="card">
                <div class="card-header">Menu</div>
                <div class="card-body">
                    <div class="list-group">         
                        <button type="button" class="btn btn-primary btn-block" onclick="openSheet(1)">{{ __('app.home.menu.option1') }}</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="openSheet(2)">{{ __('app.home.menu.option2') }}</button>
                        <button type="button" class="btn btn-primary btn-block" onclick="openSheet(3)">{{ __('app.home.menu.option3') }}</button>                
                    </div>         
                </div>
            </div> 
        </div>
        <div class="col-md-1"></div>
        <div class="col-md-8">
        @include('partials.alert')
        <div id="divTable">
        @include('home.tableMyDocuments')
        </div>
        </div>
    </div>
</div>
@include('home.contextMenu')
@include('home.create')
@include('home.edit')
@include('home.share')
@include('partials.alertModal')
@include('partials.search')
@include('partials.confirm')

@stop