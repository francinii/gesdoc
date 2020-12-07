
    <div class="modal-dialog  modal-lg modal-edit-content">
      <div class="modal-content">
        <div class="modal-header">  
            @if ( !empty($versionNum))
              <h2 id= "card-title" class="text-center">{{ __('app.documentFlow.modalEditVersion.title') }} {{$versionNum}}</h2>
            @endif    
      
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body" id = "modal-body-edit">
            <p>
              {{ __('app.documentFlow.modalEditVersion.description1') }}
              <b> {{ __('app.documentFlow.modalEditVersion.description2') }} </b>,
              {{ __('app.documentFlow.modalEditVersion.description3') }}              
            </p>             
        <label for="role_edit"><b>Acción a ejecutar</b></label>
        <div class="form-group">
          <select id="role_edit" class="form-control" name="action_create">
              @foreach ($actionStepUser as $ast)           
                  <option value="{{$ast->id_action}}" name="">{{$ast->description}}</option>              
              @endforeach                                
          </select>         
        </div>
        <div class="form-group">           
              <input type="checkbox" id ='checkboxNota' onclick="isCheckNote(this)" > {{ __('app.documentFlow.modalEditVersion.addNote') }}  
        </div>          
        <div class="form-group" id = 'textNote' style = 'display:none'>
          <label for=""><b>{{ __('app.documentFlow.modalEditVersion.note') }}</b></label>
            <textarea id = "text_notas" class="form-control" ></textarea>
        </div>
         
      </div>
        <div class="modal-footer">     
            <span class=" text-right">
                <button data-toggle="modal" class=" float-right btn btn-danger" onclick="hideModal('modal-edit-version')" data-target="">
                    <i class=""></i>{{ __('app.documentFlow.modalEditVersion.close') }}
                </button>       
              </span>  
              <span class=" text-right">
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="flowProcess({{$version->id}})" data-target="">
                  <i class=""></i>{{ __('app.documentFlow.modalEditVersion.save') }}
                </button>  
              </span>
        </div>
      </div>
   </div>
  </div>
      



