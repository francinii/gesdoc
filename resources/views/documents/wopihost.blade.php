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
	  <form id="loleafletform" name="loleafletform"  target="loleafletframe" action="{{ env('APP_URL') }}/loleaflet/dist/loleaflet.html?WOPISrc={{ env('APP_URL') }}/public/wopi/files/{{$document}}" method="post">
		<!-- <form id="loleafletform" name="loleafletform"  target="loleafletframe" action="https://192.168.1.4/gesdoc/public/wopi/files/1-last-1-1?access_token=%242y%2410%24SKpw98ivNqr1AeKd8aFRh.EYwT2GApPNe1eQ9%2FELby3vrYNuPeVVS&access_token_ttl=0&reuse_cookies=XSRF-TOKEN%3DeyJpdiI6InJtZjBlcUNUUnBzdlF5SGxDYktjYlE9PSIsInZhbHVlIjoiZGJSdnJ6Q0R6SXQ1ZVV6aXgwcm9cL0pUZG1zMnFIZTJnVGRadVZXajUxdFRaNVRXaFJXdnNPOW9kekIweVVJZmwiLCJtYWMiOiI0ZjlhM2IxNjdlMmQ4YzZiNjViZWY3MGRlOTY2ZTEyNzZlZTc2NjIwNzgwMTk1MmM2ZmM2NGJjOTljNDAyZmZjIn0%3D%3Alaravel_session%3DeyJpdiI6ImJ6YjM2Z0h5NXBESG03VlNVWWhGSVE9PSIsInZhbHVlIjoiNzUxUFFFMklGMTlpd2ZDMVhJRFhUSzM5RkpnU2EwNGljWWJCUis2MFJ4VENRV3J1NktQM2crekE5VUVTVTAxeCIsIm1hYyI6IjI1YzM1ZTJkNjZhYTcxMDkxNWY0MTNjZjdhNDJiZjgzMzQ4OTExYTVmMjYzZDg0NzUzOThjNDk1MDk2OWJhYjIifQ%3D%3D%3AA0DrEiSKL5nmWiWPPQUeXbQOKvNhAfHXqFGJuZPL%3DeyJpdiI6ImVmcHUrdmMxMEh2Rk50YldqVzMxTlE9PSIsInZhbHVlIjoicVFGdkdmN2dVK2E4RlVNdWJ5MEJYKzN3XC94dDVVVkhqcVhDbXRaeEZVYldQRVFaaTA2bHhcL0ZwdVFqV3RReE1nWW90K3BPSkY0VG5nVjhoMDhcL05QWk5TUlRGNUZ2akF0UXR3em10Y21FZWJySkZWUjJtRTVpR0RLMTZQajdWS25nekluSkJmdkpGV3VIVHA3V0lHTFFGY0c2UHAxQlNJWTJaU1plNDRBXC9qSkxXaFNRRW9ERTlpOGVDNHhJZEhQUWJXV1RFb3RNcVlGY0YwSGhNcnZWczk4U3lscEhBY1NPU0dHS1JCNFllUGFTUTJpdWtWaStzdVVseGpPVFFhcmFPSzRTc3VGdmdnaUpmVk5KZVNlTGJMTm1ObGxlUkR4Zzl6alM4Q2NsVlwvdXJDbnhURG9ZS2o2c2R2NE1rOGV6NjNvdDdxaUpcL2pnOWFqU29ydHFndlFhS01zaUVRZ3dndkc3Yjg2ZnZteTNvWXRuVkpkRytmdlhOdEhRMjVUSU1ZY0gzVWNpYTZrTFwvajNmcklYeEk4dVVZUUpyYnVHejRaRnEweEswNFBNTmhtd2YzcmtqeXVcL1QrVVpVeXRvV3grNW5YZVFLNld0MXB0bmxISWQ2UEFvSE5EbDVQcVwvQUhrMXlPVVpzbFZQXC9aK05BY0s0Z1wvZUtMMW1lWGNjU0F2N0gyZFp0TElJTG5BZVNNMTd1c0F2RHdiK3JzU1YrTTlLN3cyXC9abXBXVUNjPSIsIm1hYyI6IjYwZGRjMjViZTBhMGY3NzNmMjBlMDc4ZjhmZDgxMzYxZjdiMmI3ZThhZGE4YTI2MWIwN2Y3ZWU2MTNmZTU0ODkifQ%3D%3D" method="get"> -->
			
			
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