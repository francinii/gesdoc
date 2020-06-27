<?php $countNotes = count($notes);?>
@if ($countNotes>0)
  <div class="card " style="height: 80vh">
      <div class="card-header bg-danger ">
        <h5 class="card-title text-light">Notas de la versión: {{$versionNum}}</h5>    
      </div>
      <div class="card-body" style = "height:100%;  overflow-y:scroll; padding:2%">      
        @foreach ($notes as $note)
          <div class="card">
            <div class="card-header ">
              <span><b class="card-text card-title "></b></span>
                      
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">      
                      <div>
                        <span><b class="card-text ">Fecha de creación:</b></span>
                        <span id = '' class="card-text">{{ $note->created_at }}</span> 
                      </div>
                      <div>            
                          <span><b class="card-text ">Última modificación:</b></span>
                          <span id = '' class="card-text">{{ $note->updated_at }}</span>
                      </div>
                      <div>            
                        <span><b class="card-text ">Contenido:</b></span>
                        <span class="card-text ">{{ $note->content }}</span>   
                    </div>           
                    </div>  
                </div>
            </div>
          </div>
          <div>&nbsp;</div>   
        @endforeach
      </div>
  </div>
@else
  <div class="card-header ">
      <span><b class="card-text card-title ">No hay notas asociadas a esta versión</b></span>
  </div>
@endif

