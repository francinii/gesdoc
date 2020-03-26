<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h3 class="text-center">Editar Departamento</h3>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="idEdit">        
           <div class="form-group">            
             <label for="nameEdit">Nombre</label>
             <input type="text" class="form-control" id="nameEdit" placeholder="Nombre Departamento" name="nameEdit" value="">
            </div>           
         </form>
      </div>
      <div class="modal-footer">  
      <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">Actualizar</button>   
      </div>
    </div>
 </div>
</div>
