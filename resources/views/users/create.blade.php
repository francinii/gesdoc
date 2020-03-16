<div class="modal fade" id="create">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="text-center">Crear Usuario</h2>
        <button type="close" class="close" data-dismiss="modal">
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="id_create">
          <div class="form-group">
            <label for="user">Usuario</label>
            <input type="text" class="form-control" id="user_create" placeholder="Nombre usuario" name="user_create" value="">
          </div>
           <div class="form-group">
             <label for="name">Nombre</label>
             <input type="text" class="form-control" id="name_create" placeholder="Nombre usuario" name="name_create" value="">
            </div>
            <div class="form-group">
              <label for="email_create">Correo</label>
              <input type="email" class="form-control" id="email_create" placeholder="Nombre usuario" name="email_create" value="">
            </div>

            <label for="rol_create">Rol asociado</label>
            <div class="form-group">
              <select id="rol_create"class="form-control" name="rol_create" >
              @foreach ($rols as $rol)
              <option value="{{$rol->id}}" name ="rol_create{{$rol->id}}">{{$rol->description}}</option>
              @endforeach
              </select>
            </div>
            <label for="instancia_create">Instancia asociado</label>
            <div class="form-group">
              <select id="instancia_create"class="form-control" name="instancia_create" >
              @foreach ($instancias as $instancia)
              <option value="{{$instancia->id}}" name ="instancia_create{{$instancia->id}}">{{$instancia->description}}</option>
              @endforeach
              </select>
            </div>

           <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">Crear</button>
         </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
 </div>
</div>
