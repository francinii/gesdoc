@extends('layouts.template')
@section('head')
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div id="#mainContainer" style="width:100%; height:75vh;">
	<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="https://192.168.0.8/loleaflet/dist/loleaflet.html?WOPISrc=https://192.168.0.8/gesdoc/public/wopi/files/test.docx" method="post">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- <input name="access_token" value="{{ csrf_token() }}"  type="hidden"/> -->
		 <input name="_token" value="{{ csrf_token() }}"  type="hidden"/>
		 <input type="submit" value="Version Laravel"/>
	</form>




	<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="https://192.168.0.8/loleaflet/dist/loleaflet.html?WOPISrc=https://192.168.0.8/gesdoc/resources/extensions/WopiHost/files/test.docx" method="post">
		 <input name="access_token" value="{{ csrf_token() }}"  type="hidden"/>
		 <input type="submit" value="Load Collabora Online"/>
	</form>
 <iframe id="loleafletframe" name= "loleafletframe"   allowfullscreen style="width:100%; height:100%;"></iframe>
</div> 
@stop