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
          <input type="hidden" id="edit_id">
          <div class="form-group">            
            <label for="user">Usuario</label>
            <input type="text" disabled class="form-control" id="user" placeholder="Nombre usuario" name="user" value="">
          </div>         
           <div class="form-group">            
             <label for="name">Nombre</label>
             <input type="text" class="form-control" id="name" placeholder="Nombre usuario" name="name" value="">
            </div> 
            <div class="form-group">            
              <label for="email">Correo</label>
              <input type="email" class="form-control" id="email" placeholder="Nombre usuario" name="email" value="">
            </div>            
            
            <label for="rol_edit">Rol asociado</label>
            <div class="form-group">                         
              <select id="rol_edit"class="form-control" name="rol" >
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
