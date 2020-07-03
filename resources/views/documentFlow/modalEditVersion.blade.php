
    <div class="modal-dialog  modal-lg modal-edit-content">
      <div class="modal-content">
        <div class="modal-header">  
            @if ( !empty($versionNum))
        <h2 id= "card-title" class="text-center">Acciones sobre el flujo de
           la version {{$versionNum}}</h2>
            @endif    
      
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body" id = "modal-body-edit">
            <p>
              Al ejecutar "una acción de flujo" sobre el documento actual, se enviará
              esta versión al siguiente paso del flujo. Al hacer esto,
                <b>NO podrá editar esta versión nuevamente</b>,
              únicamente podrá ver dicho documento o las versiones
              anteriores a este. 
            </p>             
        <label for="role_edit"><b>Acción a ejecutar</b></label>
        <div class="form-group">
          <select id="role_edit" class="form-control" name="action_create">
              @foreach ($actionStepUser as $ast)           
                  <option value="{{$ast->id_action}}" name="">{{$ast->description}}</option>              
              @endforeach                                
          </select>         
        </div>
        <div class="form-group">
          <label for="role_edit"><b>Con modificaciones</b></label>
       
        </div>
          
        <div class="form-group">
          <label for=""><b>Notas</b></label>
            <textarea class="form-control" >
            </textarea>
        </div>
         
      </div>
        <div class="modal-footer">     
            <span class=" text-right">
                <button data-toggle="modal" class=" float-right btn btn-danger" onclick="hideModal('modal-edit-version')" data-target="">
                    <i class=""></i>Cerrar
                </button>       
              </span>  
              <span class=" text-right">
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="flowProcess({{$version->id}})" data-target="">
                  <i class=""></i>Guardar
                </button>  
              </span>
        </div>
      </div>
   </div>
  </div>
      



