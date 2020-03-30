<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h3 class="text-center">{{ __('app.users.edit.title') }}</h3>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="id_edit">
          <div class="form-group">            
            <label for="user_edit">{{ __('app.users.edit.user') }}</label>
            <input type="text" disabled class="form-control" id="user_edit" placeholder="{{ __('app.users.edit.username') }}" name="user_edit" value="">
          </div>         
           <div class="form-group">            
             <label for="name_edit">{{ __('app.users.edit.name') }}</label>
             <input type="text" class="form-control" id="name_edit" placeholder="{{ __('app.users.edit.name') }}" name="name_edit" value="">
            </div> 
            <div class="form-group">            
              <label for="email_edit">{{ __('app.users.edit.email') }}</label>
              <input type="email" class="form-control" id="email_edit" placeholder="{{ __('app.users.edit.email') }}" name="email_edit" value="">
            </div>            
            
            <label for="role_edit">{{ __('app.users.edit.role') }}</label>
            <div class="form-group">
              <select id="role_edit"class="form-control" name="role_edit" >
              @foreach ($roles as $role)
              <option value="{{$role->id}}" name ="role_edit{{$role->id}}">{{$role->description}}</option>
              @endforeach
              </select>
            </div>
            <label for="department_edit">{{ __('app.users.edit.department') }}</label>
            <div class="form-group">
              <select id="department_edit"class="form-control" name="department_edit" >
              @foreach ($departments as $department)
              <option value="{{$department->id}}" name ="department_edit{{$department->id}}">{{$department->description}}</option>
              @endforeach
              </select>
            </div>
            @if (!env("use_LDAP"))
            <div class="form-group">            
              <label for="password_edit">{{ __('app.users.edit.password') }}</label>
              <input type="checkbox" id="checkbox_password" name="checkbox_password" onclick="change_password()">
              <input type="password" class="form-control" id="password_edit" placeholder="{{ __('app.users.edit.passwordnew') }}" name="password_edit" disabled >
              <span class="invalid-feedback" role="alert">
                    <strong id="password_edit_message"></strong>
                </span>
            </div> 
            @endif
          
         </form>
      </div>
      <div class="modal-footer">  
      <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>   
      </div>
    </div>
 </div>
</div>
