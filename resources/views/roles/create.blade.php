<div id = "create" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >
  <div class="modal-dialog" role="document" >
      <div class="modal-content">
      <div class="modal-header">      
          <h5 class="modal-title">Nuevo Rol</h5>
          <button type="close" class="close" data-dismiss="modal">  X </button>
      </div>
      <div class="modal-body">   
        <form action="{{ action('RoleController@index') }}" method="POST">
        {{csrf_field()}}
          <div class="form-group">
            <label for="role">Nombre del rol</label>
            <input type="text" class="form-control" id="CreateDescription" placeholder="Nombre del rol" name="CreateDescription">
          </div>
          
            @foreach ($permissions as $permission)
              <div class="checkbox">
                <label for="checkCreate{{$permission->id}}">
                  <input id="checkCreate{{$permission->id}}" value='{{$permission->id}}' class ="input_check_create" type="checkbox"/> 
                  {{$permission->description}}
                </label>
              </div>
            @endforeach         
              
          <button  type="button" id="CreateSubmit" onclick="ajaxCreate()" class="btn btn-success">Agregar</button>
        </form>    
      </div>
      <div class="modal-footer"> </div>
      </div>
  </div>
</div>


  



