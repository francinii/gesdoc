<div class="modal fade" id="edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 class="text-center">Editar Flujo</h2>
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
                <input name="id" type="hidden">
                <label for="rol">Nombre del flujo</label>
                <input type="text" class="form-control" id="description" placeholder="Nombre del rol" name="description" value="">
            </div> 
            <label for="flujoUsuario">Pasar propiedad del flujo a otro usuario</label>              
            <div class="form-group">
                <select id="flujoUsuario"class="form-control" name="flujoUsuario" >
                    @foreach ($users as $user)
                        <option value="{{$user->id}}" name ="flujoUsuario{{$user->id}}" >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>               
  
             <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">Actualizar</button>
           </form>
        </div>
        <div class="modal-footer">     
        </div>
      </div>
   </div>
  </div>
  