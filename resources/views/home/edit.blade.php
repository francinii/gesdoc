<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h3 class="text-center">{{ __('app.home.edit.title') }}</h3>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="idEdit">        
           <div class="form-group">            
             <label for="descriptionEdit">{{ __('app.home.edit.name') }}</label>
             <input type="text" class="form-control" id="descriptionEdit" placeholder="{{ __('app.home.edit.name') }}" name="descriptionEdit" value="">
            </div>
            <div class="card">
                <div class="card-header">{{ __('app.home.edit.move') }}</div>
                <div class="card-body">
                <span class="btn badge badge-danger badge-pill" onclick="editBackClassification({{$allClassification}})"><i class="fas fa-long-arrow-alt-left"></i></span>
                <input name="editClassification" type="hidden">
                <div id="listEdit" class="list-group">                    
                    

                    </div>  
                  
                </div>
            </div>
                   
         </form>
      </div>
      <div class="modal-footer"> 
      <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>   
      </div>
    </div>
 </div>
</div>
