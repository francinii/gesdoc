<div class="modal fade" id="edit">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 class="text-center">{{ __('app.flows.edit.title') }}</h2>
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
                <input name="id" type="hidden">
                <label for="rol">{{ __('app.flows.edit.name') }}</label>
                <input type="text" class="form-control" id="description" placeholder="{{ __('app.flows.edit.name') }}" name="description" value="">
            </div> 
            <label for="flowUsuario">{{ __('app.flows.edit.property') }}</label>              
            <div class="form-group">
                <select id="flowUsuario" class="form-control" name="flowUsuario" >
                    @foreach ($users as $user)
                        <option value="{{$user->id}}" name ="flowUsuario{{$user->id}}" >{{$user->name}}</option>
                    @endforeach
                </select>
            </div>               
  
            <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>
           </form>
        </div>
        <div class="modal-footer">     
        </div>
      </div>
   </div>
  </div>
  