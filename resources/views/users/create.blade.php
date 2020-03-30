<div class="modal fade" id="create">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="text-center">{{ __('app.users.create.title') }}</h3>
        <button type="close" class="close" data-dismiss="modal">
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="hidden" id="id_create">
          <div class="form-group">
            <label for="user_create">{{ __('app.users.create.username') }}</label>
            @if (env("use_LDAP"))
            <input type="text" onchange="obtenerDatos()" class="form-control" id="user_create" placeholder="{{ __('app.users.create.username') }}" name="user_create" >
            @else
            <input type="text" class="form-control " id="user_create" placeholder="{{ __('app.users.create.username') }}" name="user_create" >
            @endif            
              <span class="invalid-feedback" role="alert">
                  <strong id="user_create_message"></strong>
              </span>            
          </div>
           <div class="form-group">
             <label for="name">{{ __('app.users.create.name') }}</label>
             <input type="text" class="form-control" id="name_create" placeholder="{{ __('app.users.create.name') }}" name="name_create">
                     
            </div>
            <div class="form-group">
              <label for="email_create">{{ __('app.users.create.email') }}</label>
              <input type="email" class="form-control" id="email_create" placeholder="{{ __('app.users.create.email') }}" name="email_create">
                
            </div>

            <label for="role_create">{{ __('app.users.create.role') }}</label>
            <div class="form-group">
              <select id="role_create"class="form-control" name="role_create" >
              @foreach ($roles as $role)
              <option value="{{$role->id}}" name ="role_create{{$role->id}}">{{$role->description}}</option>
              @endforeach
              </select>
            </div>
            <label for="department_create">{{ __('app.users.create.department') }}</label>
            <div class="form-group">
              <select id="department_create"class="form-control" name="department_create" >
              @foreach ($departments as $department)
              <option value="{{$department->id}}" name ="department_create{{$department->id}}">{{$department->description}}</option>
              @endforeach
              </select>
            </div>
            @if (!env("use_LDAP"))
            <div class="form-group">
              <label for="password_create">{{ __('app.users.create.password') }}</label>
              <input type="password" class="form-control " id="password_create" placeholder="{{ __('app.users.create.password') }}" name="password_create">
              
                <span class="invalid-feedback" role="alert">
                    <strong id="password_create_message"></strong>
                </span>
              
            </div>
            @endif

         </form>
      </div>
      <div class="modal-footer">
        <button type="button" onclick="ajaxCreate() "id="CreateSubmit" class="btn btn-success">{{ __('app.buttons.add') }}</button>
      </div>
    </div>
 </div>
</div>
