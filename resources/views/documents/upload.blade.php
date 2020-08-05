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
              <input type="file" id="file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" /> <label for="file" class="btn-3 btn-info btn-block"> <i class="fa fa-upload"></i> Importar documento</label>
              <span class="text-danger" role="alert">
                  <strong id="file_message"></strong>
              </span> 
            </div>

            <div class="form-group">
              <label for="nameU">{{ __('app.documents.general.name') }}</label>
              <input type="text" class="form-control" id="nameU" placeholder="{{ __('app.documents.general.name') }}" name="">

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
              <label for="codeU">{{ __('app.documents.general.code') }}</label>
              <input type="text" class="form-control" id="codeU" placeholder="{{ __('app.documents.general.code') }}" name="">
            </div>
            <div class="form-group">
              <label for="languajeU">{{ __('app.documents.general.languaje') }}</label>
              <input type="text" class="form-control" id="languajeU" placeholder="{{ __('app.documents.general.languaje') }}" name=""></textarea>
            </div>                         
            <div class="form-group">
              <label for="summaryU">{{ __('app.documents.general.summary') }}</label>
              <textarea type="text" class="form-control" id="summaryU" placeholder="{{ __('app.documents.general.summary') }}" name=""></textarea>
            </div>
            <div class="form-group">
              <label for="othersU">{{ __('app.documents.general.others') }}</label>
              <textarea type="text" class="form-control" id="othersU" placeholder="{{ __('app.documents.general.others') }}" name=""></textarea>
            </div>               
          </form>    
        </div>
        <div class="modal-footer">
        <button  type="button" id="CreateSubmit" onclick="ajaxUploadDoc(1)" class="btn btn-success">Crear</button>
         </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  