
    <div class="col-6 panel-preview" style="height: 80vh">
        <div class="card" style="height:100%;">        
            <div class="card-header bg-danger">
                <div class="row">
                    <div class="col-4">
                        <span> <b class="text-light">Versión anterior</b></span> 
                    </div>     
                    <div class="col-4 text-center">
                        <div >
                            <span  class=""><button onclick="modalOldDoc(1,{{ $version->version }} )" class="btn-sm btn btn-danger" > <i class="fa fa-chevron-left"></i></button></span>  
                            <span> <b class="text-light">{{ $version->version }} </b></span>                            
                            <span  class=""><button onclick="modalOldDoc(2,{{ $version->version }} )" class="btn-sm btn btn-danger" > <i class="fa fa-chevron-right"></i></button></span>   
                        </div>
                    </div> 
                    <div class="col-4">                                 
                        <span  class=" float-right" ><button onclick="modalNotes({{ $version->version }} )" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i> Notas</button></span>                 
                    </div>      
                </div>
            </div>
            <div  class="card-body" style = "height: 100vh">      
                
                    <iframe src='http://docs.google.com/gview?url={{$version->content}}&embedded=true' width='100%' height='100%' frameborder='0'></iframe>  
            </div>
        </div> 
    </div>
    <div class="col-6 panel-preview" style="height: 80vh">
        <div class="card" style="height:100%;">        
            <div class="card-header bg-danger">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <span> <b class="text-light">Version actual </b></span>
                            <span class="card-text text-light "> </span>
                            <span  class=" float-right"><button onclick="modalNotes()" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i> Notas</button></span>  
                            <span  class=" float-right"><button onclick="download()" class="btn-sm btn btn-danger" > <i class="fas fa-download"></i> Descargar</button></span>  
                            <span  class=" float-right"><button onclick="upload()" class="btn-sm btn btn-info" > <i class="fas fa-upload"></i> Subir</button></span>  
                            <span  class=" float-right"><button onclick="save()" class="btn-sm btn btn-success" > <i class="fas fa-save"></i> Guardar</button></span>    
                        </div>                                          
                                                                           
                    </div>            
                </div>
            </div>
            <div  class="card-body" style = "height: 100vh">       
                <!--Cambiar content por route-->        
                <iframe src='http://docs.google.com/gview?url={{$version->content}}&embedded=true' width='100%' height='100%' frameborder='0'></iframe>  
            </div>
        </div> 

    </div>



