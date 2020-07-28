@extends('layouts.template')
@section('head')
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div id="#mainContainer" style="width:100%; height:75vh;">

	<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="https://192.168.1.2/loleaflet/dist/loleaflet.html?WOPISrc=https://192.168.1.2/gesdoc/public/wopi/files/test.docx" method="post">

<!--https://192.168.1.2/gesdoc/public/wopi/files/test.docx/contents?access_token=BiThI7Edm6r5dHaydyS59omjisIr4WvNJPcZ2X8i&access_token_ttl=0	-->	
<!-- https://192.168.1.2/gesdoc/public/wopi/files/test.docx -->	
		 <input name="access_token" value="<?php echo $username ?>"  type="hidden"/>

		 <input type="submit" value="Load Collabora Online"/>
	</form>
 <iframe id="loleafletframe" name= "loleafletframe"   allowfullscreen style="width:100%; height:100%;"></iframe>
</div> 
@stop