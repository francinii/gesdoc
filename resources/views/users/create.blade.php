<div class="modal fade" id="create">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="text-center">Crear Usuario</h3>
        <button type="close" class="close" data-dismiss="modal">
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="id_create">
          <div class="form-group">
            <label for="user_create">Usuario</label>
            @if (env("use_LDAP"))
            <input type="text" onchange="obtenerDatos()" class="form-control" id="user_create" placeholder="Nombre usuario" name="user_create" >
            @else
            <input type="text" class="form-control " id="user_create" placeholder="Nombre usuario" name="user_create" >
            @endif            
              <span class="invalid-feedback" role="alert">
                  <strong id="user_create_message"></strong>
              </span>            
          </div>
           <div class="form-group">
             <label for="name">Nombre</label>
             <input type="text" class="form-control" id="name_create" placeholder="Nombre usuario" name="name_create">
                     
            </div>
            <div class="form-group">
              <label for="email_create">Correo</label>
              <input type="email" class="form-control" id="email_create" placeholder="Nombre usuario" name="email_create">
                
            </div>

            <label for="role_create">Rol asociado</label>
            <div class="form-group">
              <select id="role_create"class="form-control" name="role_create" >
              @foreach ($roles as $role)
              <option value="{{$role->id}}" name ="role_create{{$role->id}}">{{$role->description}}</option>
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
            @if (!env("use_LDAP"))
            <div class="form-group">
              <label for="password_create">Contraseña</label>
              <input type="password" class="form-control " id="password_create" placeholder="contraseña" name="password_create">
              
                <span class="invalid-feedback" role="alert">
                    <strong id="password_create_message"></strong>
                </span>
              
            </div>
            @endif

         </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="ajaxCreate() "id="CreateSubmit" class="btn btn-success">Crear</button>
      </div>
    </div>
 </div>
</div>
