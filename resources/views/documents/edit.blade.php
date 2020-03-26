<div id = "edit" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">Editar Documento</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="{{ action('DocumentController@index') }}" method="POST">
          <input type="hidden" id="idEdit"> 
            <div class="form-group">
              <label for="descriptionEdit">Nombre del documento</label>
              <input type="text" class="form-control" id="descriptionEdit" placeholder="Nombre del documento" name="descriptionEdit">
            </div>    
            <label for="editFlow">Flujo asociado</label>
            <div class="form-group">
              <select id="editFlow"class="form-control" name="editFlow" >
                  @foreach ($flows as $flow)
                    <option value="{{$flow->id}}" name ="flowEdit{{$flow->id}}">{{$flow->description}}</option>
                  @endforeach
              </select>
            </div>
              
          </form>    
        </div>
        <div class="modal-footer">
          <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">Actualizar</button>
        </div>
        </div>
    </div>
  </div>
  