<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h2 class="text-center">Editar Rol</h2>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
        
           <div class="form-group">
            <input name="id" type="hidden">
             <label for="role">Nombre del rol</label>
             <input type="text" class="form-control" id="description" placeholder="Nombre del rol" name="description" value="">
            </div> 
            <label for="role">Permisos asociados</label>
            <div id="check_permissions">              
            </div>   
           <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">Actualizar</button>
         </form>
      </div>
      <div class="modal-footer">     
      </div>
    </div>
 </div>
</div>
