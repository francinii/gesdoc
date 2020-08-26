<div class="card" style="height:100%;">        
        <div class="card-header bg-danger">
            <div class="row">
                <div class="col-12">
                    <div id = "actualVersionButton">
                        <input type="hidden" id="actualVersion" value = '{{$actualVersion->version}}'>
                        <span> <b class="text-light">{{ __('app.documentFlow.actualVersion.title') }} {{$actualVersion->version}} </b></span>
                        <span class="card-text text-light "> </span>
                        
                        <span  title = "{{ __('app.documentFlow.actualVersion.notes') }} " class=" float-right"><button onclick="modalNotes({{$actualVersion->id }},{{$actualVersion->version}})" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i> </button></span>  
                       <!-- $screen = 1 is for "Documentos asociados a mis flujos" and 2 is for "Documentos compartidos a mis flujos" -->
                        @if($screen == 2)
                        <span  title = "{{ __('app.documentFlow.actualVersion.upload') }} " class=" float-right"><button onclick="upload()" class="btn-sm btn btn-primary" > <i class="fas fa-upload"></i> </button></span>
                        <span  title = "{{ __('app.documentFlow.actualVersion.edit') }}" class=" float-right"><button class="btn-sm btn btn-info" onclick="editionMode({{$actualVersion->document_id }},{{$actualVersion->version}})"> <i class="fas fa-edit"></i> </button></span>                       
                        <span  title = "{{ __('app.documentFlow.actualVersion.executeActionDes') }}" class=" float-right"><button onclick="modalEdit({{$actualVersion->id }},{{$actualVersion->version}})"  class="btn-sm btn btn-success" > <i class="fa fa-play"></i> {{ __('app.documentFlow.actualVersion.executeAction') }}</button></span>    
                        @endif
                    </div>                                                                                         
                </div>            
            </div>
        </div>
        <div  class="card-body" style = "height: 100vh">
                <form id="loleafletframe" name="loleafletframe"  target="loleafletframe" action="{{ env('APP_URL') }}/loleaflet/dist/loleaflet.html?WOPISrc={{ env('APP_URL') }}/gesdoc/public/wopi/files/{{$document}}" method="post">
                    <input name="access_token" value="{{ $api_token}}"  type="hidden"/>
                </form>  
                <iframe id="loleafletframe" name= "loleafletframe"   allowfullscreen width='100%' height='100%' frameborder='0'></iframe>  
        </div>
        <script>
            $( document ).ready(function() {
                $("#loleafletframe").submit() 
            });
        </script>
        @include('documentFlow.upload') 
</div>

