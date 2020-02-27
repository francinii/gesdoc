<div id = "create" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document" >
      <div class="modal-content">
      <div class="modal-header">      
          <h5 class="modal-title">Nuevo Rol</h5>
          <button type="close" class="close" data-dismiss="modal">  X </button>
      </div>
      <div class="modal-body">   
        <form action="{{ action('RolController@index') }}" method="POST">
          {{csrf_field()}}  
          <div class="form-group">
            <label for="rol">Nombre del rol</label>
            <input type="text" class="form-control" id="rol" placeholder="Nombre del rol" name="description">
          </div>      
          <button type="submit" class="btn btn-success">Agregar</button>
        </form>    
      </div>
      <div class="modal-footer"> </div>
      </div>
  </div>
</div>


  



