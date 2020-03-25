<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h3 class="text-center">Editar Usuario</h3>
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
         </form>
      </div>
      <div class="modal-footer">  
      <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">Actualizar</button>   
      </div>
    </div>
 </div>
</div>
