<div id = "createDocument" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">{{ __('app.documents.create.title') }}</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="{{ action('DocumentController@index') }}" method="POST">
          {{csrf_field()}}
            <div class="form-group">
              <label for="descriptionCreate">{{ __('app.documents.create.name') }}</label>
              <input type="text" class="form-control" id="descriptionCreate" placeholder="{{ __('app.documents.create.name') }}" name="descriptionCreate">
            </div>    
            <label for="flowCreate">{{ __('app.documents.create.flow') }}</label>
            <div class="form-group"> 
              <select id="flowCreate"class="form-control" name="flowCreate" >
                  @foreach ($flows ?? '' as $flow)
                    <option value="{{$flow->id}}" name ="flowCreate{{$flow->id}}">{{$flow->description}}</option>
                  @endforeach
              </select>
            </div>            
            <div class="form-group">
              <label for="code">Código del documento</label>
              <input type="text" class="form-control" id="code" placeholder="Código del documento" name="">
            </div>                        
            <div class="form-group">
              <label for="summary">Resumen del contenido</label>
              <textarea type="text" class="form-control" id="summary" placeholder="Resumen de contenido" name=""></textarea>
            </div>              
          </form>    
        </div>
        <div class="modal-footer">
        <button  type="button" id="CreateSubmit" onclick="ajaxCreateDoc({{ Auth::user()->id }}, 0)" class="btn btn-success">Agregar</button>
         </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  