  <div class="card " style="height: 80vh">
      <div class="card-header bg-danger ">
        <h5 class="card-title text-light">{{ __('app.documentFlow.previewVersion.title') }} {{$versionNum}} </h5>    
      </div>
      <div class="history-view" style = "height:100%;">           
         <form id="loleafletframeOld" name="loleafletframeOld"  target="loleafletframeOld" action="{{ env('APP_URL') }}/loleaflet/dist/loleaflet.html?WOPISrc={{ env('APP_URL') }}/public/wopi/files/{{$document}}" method="post">
            <input name="access_token" value="{{ $api_token}}"  type="hidden"/>
        </form>  
        <iframe id="loleafletframeOld" name= "loleafletframeOld"   allowfullscreen width='100%' height='100%' frameborder='0'></iframe>          
      </div>
      <script>
            $( document ).ready(function() {
                $("#loleafletframeOld").submit() 
            });
        </script> 
  </div>


