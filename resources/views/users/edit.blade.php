<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h2 class="text-center">Editar Usuario</h2>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="id_edit">
          <div class="form-group">            
            <label for="user_edit">Usuario</label>
            <input type="text" disabled class="form-control" id="user_edit" placeholder="Nombre usuario" name="user_edit" value="">
          </div>         
           <div class="form-group">            
             <label for="name_edit">Nombre</label>
             <input type="text" class="form-control" id="name_edit" placeholder="Nombre usuario" name="name_edit" value="">
            </div> 
            <div class="form-group">            
              <label for="email_edit">Correo</label>
              <input type="email" class="form-control" id="email_edit" placeholder="Nombre usuario" name="email_edit" value="">
            </div>            
            
            <label for="rol_edit">Rol asociado</label>
            <div class="form-group">
              <select id="rol_edit"class="form-control" name="rol_edit" >
              @foreach ($rols as $rol)
              <option value="{{$rol->id}}" name ="rol_edit{{$rol->id}}">{{$rol->description}}</option>
              @endforeach
              </select>
            </div>
            <label for="instancia_edit">Instancia asociado</label>
            <div class="form-group">
              <select id="instancia_edit"class="form-control" name="instancia_edit" >
              @foreach ($instancias as $instancia)
              <option value="{{$instancia->id}}" name ="instancia_edit{{$instancia->id}}">{{$instancia->description}}</option>
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
