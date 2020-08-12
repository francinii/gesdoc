<div class="card" style="height:100%;">        
        <div class="card-header bg-danger">
            <div class="row">
                <div class="col-4">

                    <span> <b class="text-light">Versión anterior</b></span> 
                </div>     
                <div class="col-4 text-center">
                    <div >                     
                        <input type="hidden" id="oldlVersion" value = '{{$oldVersion->id}}'>
                        <span  class=""><button onclick="nextVersion(1,'{{ $oldVersion->version }}', {{$doc}} )" class="btn-sm btn btn-danger" > <i class="fa fa-chevron-left"></i></button></span>  
                        <span> <b class="text-light">{{ $oldVersion->version }} </b></span>                            
                        <span  class=""><button onclick="nextVersion(2,'{{ $oldVersion->version }}', {{$doc}})" class="btn-sm btn btn-danger" > <i class="fa fa-chevron-right"></i></button></span>   
                    </div>
                </div> 
                <div  class="col-4">   
                    <div id = "actualVersionButton">                           
                        <span  class=" float-right" ><button title = "Notas" onclick="modalNotes({{ $oldVersion->id }},{{$oldVersion->version}} )" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i> </button></span>                 
                    </div>   
                </div>      
            </div>
        </div>
        <div  class="card-body" style = "height: 100vh">
                <form id="loleafletframeOld" name="loleafletframeOld"  target="loleafletframeOld" action="{{ env('APP_URL') }}/loleaflet/dist/loleaflet.html?WOPISrc={{ env('APP_URL') }}/gesdoc/public/wopi/files/{{$documet}}" method="post">
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
