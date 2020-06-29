    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">  
            @if ( !empty($versionNum))
                <h2 id= "card-title" class="text-center">Notas asociadas a la versión: {{$versionNum  or empty($myvar)}}</h2>
            @endif    
      
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body" id = "modal-body-notes">
            
        </div>       
        <div class="modal-footer">     
            <div class="col-md-9 text-right">
                <button data-toggle="modal" class=" float-right btn btn-danger" onclick="hideModalCardSave()" data-target="">
                    <i class=""></i>Cerrar
                </button>    
              </div>  
        </div>
      </div>
   </div>
      



