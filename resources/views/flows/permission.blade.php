<div class="modal fade" id="permissionModalS">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h5>Asociar permisos a usuarios</h5>
          <button type="close" class="close" data-dismiss="modal"> X</button>
        </div>       
        <div class="modal-body">            
            <div class="form-group">   
                <label for="idPermissionModal">Paso</label>                                                                     
                <select id='idPermissionModal' onchange="permissionModalTable({{$flow->id}},{{$actions}})" class="form-control" >  
                    @foreach ($steps as $step) 
                    @if($step->id != 'draggable_inicio' && $step->id != 'draggable_final')   
                        <option value="{{$step->id}}">{{$step->description}}</option>
                    @endif   
                    @endforeach                                  
                </select>                           
            </div>    
            <div id ='permtable'>          
                @include('flows.permissionTable')
            </div>
        </div>     
        <div class="modal-footer">     
        <div class="col-md-9 text-right">          
            <span>
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="savePermissionsModal({{$flow->id}},0)" data-target="">
                    <i class="fas fa-save"></i> Guardar Paso
                </button> 
                <span>&nbsp;</span> 
            </span>
            <span>
                <button data-toggle="modal" class=" float-right btn btn-warning" onclick="savePermissionsModal({{$flow->id}},1)" data-target="">
                    <i class="fas fa-save"></i> Guardar y Cerrar
                </button>   
                <span>&nbsp;</span> 
            </span>
        </div>  
        </div>
      </div>
    </div>
   </div>

      



