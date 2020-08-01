<?php $countActions = count($actions);?>
@if ($countActions>0)
  <div class="card " style="height: 80vh">
      <div class="card-header bg-danger ">
        <h5 class="card-title text-light">Acciones sobre la versión: {{ $versionNum }}</h5>    
      </div>
      <div class="card-body" style = "height:100%;  overflow-y:scroll; padding:2%">      
        @foreach ($actions as $action)
          <div class="card">
            <div class="card-header ">
              <span><b class="card-text card-title "></b></span>
                      
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">      
                      <div>
                        <span><b class="card-text ">Fecha de creación:</b></span>
                        <span id = '' class="card-text">{{ $action->created_at }}</span> 
                      </div>
                      <div>            
                          <span><b class="card-text ">Última modificación:</b></span>
                          <span id = '' class="card-text">{{ $action->updated_at }}</span>
                      </div>
                      <div>            
                        <span><b class="card-text ">Realizado por:</b></span>
                        <span id = '' class="card-text">  {{ $action->name_user }} con 
                          identificación  {{ $action->username }}
                        </span>
                      </div>                      
                      <div>            
                        <span><b class="card-text ">Descripción:</b></span>
                        <span class="card-text ">{{ $action->description }}
                        
                        
                        </span>   
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
      <span><b class="card-text card-title ">No hay acciones asociadas a esta versión.</b></span>
  </div>
@endif

