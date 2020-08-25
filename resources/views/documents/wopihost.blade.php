@extends('layouts.template')
@section('head')
<script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/sharedDocumentFunctions.js') }}" defer></script> 
@stop
@section('title', 'Documento')
@section('header')
@include('layouts.header')
@stop
@section('content')

	<div  id="mainContainer" class="row " style="width:100%; height:85vh; margin:0 auto" >
		<div class="col-md-12">	
			<span  title = "Versiones" class=" float-right">
				<button onclick = "historial({{$id}})"  class="btn btn-warning "  data-toggle="modal" >
					<i class="fas fa-file"></i> {{ __('app.documents.wopihost.title') }}
				</button>
			</span>	
		</div>		
		<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="{{ env('APP_URL') }}/loleaflet/dist/loleaflet.html?WOPISrc={{ env('APP_URL') }}/gesdoc/public/wopi/files/{{$document}}" method="post">
		<!--<form id="loleafletform" name="loleafletform"  target="loleafletframe" action="{{ env('APP_URL') }}/gesdoc/public/wopi/files/{{$document}}/contents" method="post">	-->
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