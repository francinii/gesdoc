<div id = "create" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">Nuevo Documento</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="{{ action('DocumentoController@index') }}" method="POST">
          {{csrf_field()}}
            <div class="form-group">
              <label for="CreateDescription">Nombre del documento</label>
              <input type="text" class="form-control" id="CreateDescription" placeholder="Nombre del documento" name="CreateDescription">
            </div>    
            <label for="flujo_create">Flujo asociado</label>
            <div class="form-group">
              <select id="flujo_create"class="form-control" name="flujo_create" >
                  @foreach ($flujos as $flujo)
                    <option value="{{$flujo->id}}" name ="flujo{{$flujo->id}}">{{$flujo->description}}</option>
                  @endforeach
              </select>
            </div>
                      
                
            <button  type="button" id="CreateSubmit" onclick="ajaxCreate({{ Auth::user()->id }})" class="btn btn-success">Agregar</button>
          </form>    
        </div>
        <div class="modal-footer"> </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  