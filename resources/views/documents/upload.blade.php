<div id = "uploadDocument" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">{{ __('app.documents.create.title') }}</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="{{ action('DocumentController@index') }}" method="POST">
          {{csrf_field()}}       

            <div id= "docUpload" class="form-group">
              <label for="uploadLabel">Subir documento</label>   
              <input type="file" id="file" /> <label for="file" class="btn-3 btn-info btn-block"> <i class="fa fa-upload"></i> Importar documento</label>            
            </div>  

            <label for="flowCreate">{{ __('app.documents.create.flow') }}</label>
            <div class="form-group"> 
              <select id="flowCreate"class="form-control" name="flowCreate" >
                <option value="-1" name ="">Seleccione...</option>                 
                  @foreach ($flows ?? '' as $flow)
                    <option value="{{$flow->id}}" name ="flowCreate{{$flow->id}}">{{$flow->description}}</option>
                  @endforeach
              </select>
            </div>            
            <div class="form-group">
              <label for="code">Código del documento</label>
              <input type="text" class="form-control" id="codeU" placeholder="Código del documento" name="">
            </div>                        
            <div class="form-group">
              <label for="summary">Resumen del contenido</label>
              <textarea type="text" class="form-control" id="summaryU" placeholder="Resumen de contenido" name=""></textarea>
            </div>              
          </form>    
        </div>
        <div class="modal-footer">
        <button  type="button" id="CreateSubmit" onclick="ajaxUploadDoc({{ Auth::user()->username}}, 1)" class="btn btn-success">Crear</button>
         </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  