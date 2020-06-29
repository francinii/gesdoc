<div id = "uploadDocument" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">{{ __('app.documents.create.title') }}</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="{{ action('DocumentController@index') }}" method="POST" enctype="multipart/form-data">
          {{csrf_field()}}       

            <div id= "docUpload" class="form-group">
              <label for="uploadLabel">Subir documento</label>   
              <input type="file" id="file" /> <label for="file" class="btn-3 btn-info btn-block"> <i class="fa fa-upload"></i> Importar documento</label>            
            </div>  
            <div class="form-group">
              <label for="nameU">Nombreo del documento</label>
              <input type="text" class="form-control" id="nameU" placeholder="Nombre del documento" name="">
            </div>

            <label for="flowCreateU">{{ __('app.documents.create.flow') }}</label>
            <div class="form-group">          
              <select id="flowCreateU"class="form-control" name="flowCreateU" >
                <option value="-1" name ="">Seleccione...</option>                 
                  @foreach ($flows ?? '' as $flow)
                    <option value="{{$flow->id}}" name ="flowCreateU{{$flow->id}}">{{$flow->description}}</option>
                  @endforeach
              </select>
            </div>
            <label for="classificationU">{{ __('app.documents.create.classification') }}</label>
            <div class="form-group"> 
              <select id="classificationU"class="form-control" name="classificationU" >
              <option value="-1" name ="">{{ __('app.home.table.defaultClassification') }}</option>                   
                @foreach ($classifications as $classification)
                    <option value="{{$classification->id}}" name ="classificationU{{$classification->id}}">{{$classification->description}}</option>
                @endforeach
              </select>
            </div>             
            <div class="form-group">
              <label for="codeU">Código del documento en organizacion</label>
              <input type="text" class="form-control" id="codeU" placeholder="Código del documento" name="">
            </div>
            <div class="form-group">
              <label for="languajeU">Idioma del contenido</label>
              <input type="text" class="form-control" id="languajeU" placeholder="Idioma de contenido" name=""></textarea>
            </div>                         
            <div class="form-group">
              <label for="summaryU">Resumen del contenido</label>
              <textarea type="text" class="form-control" id="summaryU" placeholder="Resumen de contenido" name=""></textarea>
            </div>
            <div class="form-group">
              <label for="othresU">Otros datos</label>
              <textarea type="text" class="form-control" id="othresU" placeholder="Otros datos" name=""></textarea>
            </div>               
          </form>    
        </div>
        <div class="modal-footer">
        <button  type="button" id="CreateSubmit" onclick="ajaxUploadDoc(1)" class="btn btn-success">Crear</button>
         </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  