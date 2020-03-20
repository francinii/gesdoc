<div id = "create" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">Nuevo Flujo de trabajo</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="{{ action('FlujoController@index') }}" method="POST">
          {{csrf_field()}}
            <div class="form-group">
              <label for="CreateDescription">Nombre del flujo</label>
              <input type="text" class="form-control" id="CreateDescription" placeholder="Nombre del flujo" name="CreateDescription">
            </div>    
                      
                
            <button  type="button" id="CreateSubmit" onclick="ajaxCreate({{ Auth::user()->id }})" class="btn btn-success">Agregar</button>
          </form>    
        </div>
        <div class="modal-footer"> </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  