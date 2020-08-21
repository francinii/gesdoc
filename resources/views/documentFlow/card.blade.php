<div class="card">
    <div class="card-header ">
      <span><b class="card-text card-title ">Versión</b></span>
            <span class="card-text ">{{ $verdoc->version }}</span>       
    </div>
    <div class="card-body">
     <div class="row">
        <div class="col-12">      
          <div>
            <span><b class="card-text ">Fecha de creación:</b></span>
            <span id = '' class="card-text">{{ $verdoc->created_at }}</span> 
          </div>
          <div>            
              <span><b class="card-text ">Última modificación:</b></span>
              <span id = '' class="card-text">{{ $verdoc->updated_at }}</span>
          </div> 
          <div>
            <span><b class="card-text ">Tipo:</b></span>
            <span class="card-text ">{{ $verdoc->type }}</span>
          </div>             
        
          <div>
            <span><b class="card-text ">Tamaño:</b></span>
            <span class="card-text ">{{ $verdoc->size }}</span>
          </div> 
        </div>  
        <div class="col-12">
            <span><button onclick="openPanel(1,{{ $verdoc->id }}, {{ $verdoc->document_id }},'{{ $verdoc->version }}')" class="btn-sm btn btn-info"> <i class="fas fa-eye"></i> Ver</button></span>
            <span><button onclick="openPanel(2,{{ $verdoc->id }}, {{ $verdoc->document_id }},'{{ $verdoc->version }}')" class="btn-sm btn btn-warning" > <i class="fas fa-file"></i>Notas</button></span>
            <span><button onclick="openPanel(4,{{ $verdoc->id }}, {{ $verdoc->document_id }},'{{ $verdoc->version }}')" class="btn-sm btn btn-danger"> <i class="fas fa-clock">Acciones</i></button></span>  
        </div>
      </div>
    </div>
  </div>
  <div>&nbsp;</div>