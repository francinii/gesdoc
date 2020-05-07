<div class="modal fade" id="line-modal">
    <div class="modal-dialog">
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
                         
            <div class="form-group">
                <label for="">Acción</label> 
                <select id="flowUsuario"class="form-control" name="flowUsuario" >
                    @foreach ($users as $user)
                        <option value="{{$user->id}}" name ="flowUsuario{{$user->id}}" >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">  Eliminar linea</label>
                <button type="button" onclick="deleteLine() "id="deleteLine" class="btn btn-danger">
                    <i class="fas fa-trash-alt">
                    </i> 
                </button>
            </div>
            
          </form>
        </div>
        <div class="modal-footer">     
            <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>
        </div>
      </div>
   </div>
  </div>
  