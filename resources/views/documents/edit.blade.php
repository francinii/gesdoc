<div id = "editDocument" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
          <div class="modal-header">      
              <h5 class="modal-title">{{ __('app.documents.edit.title') }}</h5>   
              <button type="close" class="close" data-dismiss="modal">  X </button>

          </div>
          <div class="modal-body">
            <form action="{{ action('DocumentController@index') }}" method="POST">
            {{csrf_field()}}
            <input type="hidden" id="idEditDoc">   
              <div id= "docName" class="form-group">
                <label for="descriptionEditDoc">{{ __('app.documents.general.name') }}</label>
                <input type="text" class="form-control" id="descriptionEditDoc" placeholder="{{ __('app.documents.create.name') }}" name="descriptionCreate">
              </div>   

              <label for="flowEdit">{{ __('app.documents.edit.flow') }}</label>
              <div class="form-group"> 
                <select id="flowEditDoc"class="form-control" name="flowEditDoc" >
                  <option value="-1" name ="">Seleccione...</option>                 
                    @foreach ($flows ?? '' as $flow)
                      <option value="{{$flow->id}}" name ="flowEditDoc{{$flow->id}}">{{$flow->description}}</option>
                    @endforeach
                </select>
              </div>
              <div class="alert bg-warning" >
                  {{ __('app.documents.edit.note') }}
              </div>  
              <label for="classificationEditDoc">{{ __('app.documents.edit.classification') }}</label>
              <div class="form-group"> 
                <select id="classificationEditDoc"class="form-control" name="classificationEditDoc" >
                  <option value="-1" name ="">{{ __('app.home.table.defaultClassification') }}</option>
                  
                  @foreach ($classifications as $classification)
                      <option value="{{$classification->id}}" name ="classificationEditDoc{{$classification->id}}">{{$classification->description}}</option>
                  @endforeach
                </select>
              </div>           
              <div class="form-group">
                <label for="codeEditDoc">{{ __('app.documents.general.code') }}</label>
                <input type="text" class="form-control" id="codeEditDoc" placeholder="Código del documento" name="">
              </div>
              <div class="form-group">
                <label for="languajeEditDoc">{{ __('app.documents.general.languaje') }}</label>
                <input type="text" class="form-control" id="languajeEditDoc" placeholder="Idioma del  contenido" name=""></textarea>
              </div>                         
              <div class="form-group">
                <label for="summaryEditDoc">{{ __('app.documents.general.summary') }}</label>
                <textarea type="text" class="form-control" id="summaryEditDoc" placeholder="Resumen de contenido" name=""></textarea>
              </div>
              <div class="form-group">
                <label for="othersEditDoc">{{ __('app.documents.general.others') }}</label>
                <textarea type="text" class="form-control" id="othersEditDoc" placeholder="Otros datos" name=""></textarea>
              </div>    

            </form>    
          </div>
          <div class="modal-footer">
            <button  type="button" id="EditSubmitDoc" onclick="ajaxUpdateDoc()" class="btn btn-success">{{ __('app.buttons.update') }}</button>
          </div>
        </div>
    </div>
  </div>
  