@extends('layouts.template')
@section('head')
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div id="#mainContainer" style="width:100%; height:75vh;">

	<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="https://192.168.1.10/loleaflet/dist/loleaflet.html?WOPISrc=https://192.168.1.10/WopiHost/files/test.xlsx&title=hola.xlsx" method="post">
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