<div class="card">
    <div class="card-header ">
      <span><b class="card-text card-title ">Version</b></span>
            <span class="card-text ">1.0</span>       
    </div>
    <div class="card-body">
     <div class="row">
        <div class="col-8">          
          <div>
            <span><b class="card-text ">{{ $version->version }}</b></span>
            <span class="card-text ">1.0</span> 
          </div>
          <div>
            <span><b class="card-text ">Tamaño</b></span>
            <span class="card-text "></span>
          </div> 
          <div>
            <span><b class="card-text ">Tipo</b></span>
            <span class="card-text ">{{ $version->type }}</span>
          </div>  
          <div>
            <span><b class="card-text ">Accion</b></span>
            <span class="badge"  style= 'background-color:green; color:white' > Aprobado </span> <span>por</span>
            <span><b class="card-text">Francini Corrales</b></span>
          </div>  
          <div>
            <span><b class="card-text ">Departamento</b></span>
            <span class="badge "> Rectoria </span> <span>por</span>              
          </div>     
        </div>  

        <div class="col-4"> 
        <input id = 'datatime' type= 'hidden' value = '{{ $version->updated_at }}'>          
        <script>  date(); </script>
            <div>            
              <span><b class="card-text ">Fecha de modificación</b></span>
              <span class="card-text date "></span>
            </div>
            <div>
              <span><b class="card-text ">Hora</b></span>
              <span class="card-text hour"></span> 
            </div>
           
              <span><a href="#" class="btn btn-warning">Notas</a></span>
              <span><a href="#" class="btn btn-info">Descarga</a></span>
           
        </div>
      </div>
    </div>
  </div>