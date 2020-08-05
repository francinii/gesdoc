@extends('layouts.template')
@section('head')
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div id="#mainContainer" style="width:100%; height:85vh;">

	<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="{{ env('APP_URL') }}/loleaflet/dist/loleaflet.html?WOPISrc={{ env('APP_URL') }}/gesdoc/public/wopi/files/{{$documet}}" method="post">
		 <input name="access_token" value="{{ $api_token}}"  type="hidden"/>
	</form>
 <iframe id="loleafletframe" name= "loleafletframe"   allowfullscreen style="width:100%; height:100%;"></iframe>
</div>
<script>
    $( document ).ready(function() {
		$("#loleafletform").submit() 
    });
</script> 
@stop