<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h2 class="text-center">{{ __('app.roles.edit.title') }}</h2>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
        
           <div class="form-group">
            <input name="id" type="hidden">
             <label for="role">{{ __('app.roles.edit.name') }}</label>
             <input type="text" class="form-control" id="description" placeholder="{{ __('app.roles.edit.name') }}" name="description" value="">
            </div> 
            <label for="role">{{ __('app.roles.edit.permission') }}</label>
            <div id="check_permissions">              
            </div>   
           <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>
         </form>
      </div>
      <div class="modal-footer">     
      </div>
    </div>
 </div>
</div>
