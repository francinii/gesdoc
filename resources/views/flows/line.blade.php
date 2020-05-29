<div class="modal fade" id="line-modal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 class="text-center">Acciones</h2>
          <button type="close" class="close" data-dismiss="modal">   X   </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
                <input name="id" type="hidden">
            </div> 
            <div id ="div-selector-action" class="form-group">
              <label for="">Acción</label> 
              <select id="select_action"class="form-control" name="" >
                  @foreach ($actions as $action)
                      <option value="{{$action->id}}" name ="{{$action->id}}" >{{$action->description}}</option>
                  @endforeach
              </select>
          </div>  
        </form> 
        
        <div class="modal-footer">            
          <button type="button" onclick="deleteAction() "id="deleteLine" class="btn btn-danger">
                  <i class="fas fa-trash-alt">Eliminar linea </i> 
          </button>   
          <button type="button" onclick="saveAction() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>
        </div>
      </div>
   </div>
  </div>
  