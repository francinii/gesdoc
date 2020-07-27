@extends('layouts.template')
@section('head')
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div id="#mainContainer" style="width:100%; height:75vh;">

	<form id="loleafletform" name="loleafletform"  target="_blanck" action="https://192.168.1.10/WopiHost/files/prueba.docx/contents" method="post">
		 <input name="access_token" value="{{ csrf_token() }}" type="hidden"/>
		 <input type="submit" value="Load Collabora Online"/>
	</form>
 <iframe id="loleafletframe" name= "loleafletframe"   allowfullscreen style="width:100%; height:100%;"></iframe>
</div> 
</body>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</body>
<script>



</script>
@stop