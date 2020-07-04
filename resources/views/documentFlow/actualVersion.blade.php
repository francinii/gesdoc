<div class="card" style="height:100%;">        
        <div class="card-header bg-danger">
            <div class="row">
                <div class="col-12">
                    <div id = "actualVersionButton">
                        <input type="hidden" id="actualVersion" value = '{{$actualVersion->version}}'>
                        <span> <b class="text-light">Version actual </b></span>
                        <span class="card-text text-light "> </span>
                        
                        <span  title = "Notas" class=" float-right"><button onclick="modalNotes({{$actualVersion->id }},{{$actualVersion->version}})" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i> </button></span>  
                        <span  title = "Descargar" class=" float-right"><button onclick="download({{$actualVersion->version}},{{$doc}})" class="btn-sm btn btn-secondary" > <i class="fas fa-download"></i> </button></span>  
                        <span  title = "Subir" class=" float-right"><button onclick="upload()" class="btn-sm btn btn-primary" > <i class="fas fa-upload"></i> </button></span>  
                        <span  title = "Editar" class=" float-right"><button onclick="modalEdit({{$actualVersion->id }},{{$actualVersion->version}})" class="btn-sm btn btn-info" > <i class="fas fa-edit"></i> </button></span>
                        <span  title = "Guardar" class=" float-right"><button onclick="save({{$actualVersion->version}},{{$doc}})" class="btn-sm btn btn-success" > <i class="fas fa-save"></i> </button></span>    
                    </div>                                          
                                                                        
                </div>            
            </div>
        </div>
        <div  class="card-body" style = "height: 100vh">       
            <!--Cambiar content por route-->        
            <iframe src='http://docs.google.com/gview?url={{$actualVersion->content}}&embedded=true' width='100%' height='100%' frameborder='0'></iframe>  
        </div>
</div> 
