<div class="card" style="height:100%;">        
        <div class="card-header bg-danger">
            <div class="row">
                <div class="col-12">
                    <div>
                        <input type="hidden" id="actualVersion" value = '{{$actualVersion->version}}'>
                        <span> <b class="text-light">Version actual </b></span>
                        <span class="card-text text-light "> </span>
                        <span  class=" float-right"><button onclick="modalNotes({{$actualVersion->id }},{{$actualVersion->version}})" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i> Notas</button></span>  
                        <span  class=" float-right"><button onclick="download({{$actualVersion->version}},{{$doc}})" class="btn-sm btn btn-danger" > <i class="fas fa-download"></i> Descargar</button></span>  
                        <span  class=" float-right"><button onclick="upload()" class="btn-sm btn btn-info" > <i class="fas fa-upload"></i> Subir</button></span>  
                        <span  class=" float-right"><button onclick="save({{$actualVersion->version}},{{$doc}})" class="btn-sm btn btn-success" > <i class="fas fa-save"></i> Guardar</button></span>    
                    </div>                                          
                                                                        
                </div>            
            </div>
        </div>
        <div  class="card-body" style = "height: 100vh">       
            <!--Cambiar content por route-->        
            <iframe src='http://docs.google.com/gview?url={{$actualVersion->content}}&embedded=true' width='100%' height='100%' frameborder='0'></iframe>  
        </div>
</div> 
