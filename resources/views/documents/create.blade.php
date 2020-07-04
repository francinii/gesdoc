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
          
            <div id= "docName" class="form-group">
              <label for="descriptionCreate">{{ __('app.documents.general.name') }}</label>
              <input type="text" class="form-control" id="descriptionCreate" placeholder="{{ __('app.documents.general.name') }}" name="descriptionCreate">
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
            <label for="classificationCreate">{{ __('app.documents.create.classification') }}</label>
            <div class="form-group"> 
              <select id="classificationCreate"class="form-control" name="flowCreate" >
              <option value="-1" name ="">{{ __('app.home.table.defaultClassification') }}</option>                   
                @foreach ($classifications as $classification)
                    <option value="{{$classification->id}}" name ="classificationCreate{{$classification->id}}">{{$classification->description}}</option>
                @endforeach
              </select>
            </div>            
            <div class="form-group">
              <label for="code">{{ __('app.documents.general.code') }}</label>
              <input type="text" class="form-control" id="code" placeholder="{{ __('app.documents.general.code') }}" name="">
            </div>
            <div class="form-group">
              <label for="languaje">{{ __('app.documents.general.languaje') }}</label>
              <input type="text" class="form-control" id="languaje" placeholder="{{ __('app.documents.general.languaje') }}" name=""></textarea>
            </div>                         
            <div class="form-group">
              <label for="summary">{{ __('app.documents.general.summary') }}</label>
              <textarea type="text" class="form-control" id="summary" placeholder="{{ __('app.documents.general.summary') }}" name=""></textarea>
            </div>
            <div class="form-group">
              <label for="others">{{ __('app.documents.general.others') }}</label>
              <textarea type="text" class="form-control" id="others" placeholder="Otros datos" name=""></textarea>
            </div>    

          </form>    
        </div>
        <div class="modal-footer">
        <button  type="button" id="CreateSubmit" onclick="ajaxCreateDoc(0)" class="btn btn-success">{{ __('app.buttons.add') }}</button>
         </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  