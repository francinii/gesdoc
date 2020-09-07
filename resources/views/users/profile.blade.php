@extends('layouts.template')

@section('head')
<script src="{{ asset('../resources/js/sharedfunctions.js') }}" defer></script>
<script src="{{ asset('../resources/js/profile.js') }}" defer></script> 
@stop
@section('title', 'Usuarios')
@section('header')
@include('layouts.header')
@stop
@section('content')
<div class="container-fluid">
   <div class="row  justify-content-center">         
        <h2 class="text-center">{{ __('app.users.index.profile') }}</h2>                      
   </div>    
   <div class="row  justify-content-center">        

        <div  class="col-md-12">&nbsp</div>
        <div class="col-md-9 ">
        @include('partials.alert')
        <form action="" method="POST" onkeydown="return event.key != 'Enter';">
          
          <div class="form-group">            
            <label for="user_edit">{{ __('app.users.edit.user') }}</label>
            <input type="text" disabled class="form-control" id="user_edit" placeholder="{{ __('app.users.edit.username') }}" name="user_edit" value="{{$user->username}}">
          </div>         
           <div class="form-group">            
             <label for="name_edit">{{ __('app.users.edit.name') }}</label>
             <input type="text" class="form-control" id="name_edit" placeholder="{{ __('app.users.edit.name') }}" name="name_edit" value="{{$user->name}}">
            </div> 
            <div class="form-group">            
              <label for="email_edit">{{ __('app.users.edit.email') }}</label>
              <input type="email" class="form-control" id="email_edit" placeholder="{{ __('app.users.edit.email') }}" name="email_edit" value="{{$user->email}}">
            </div>            
            
            <label for="department_edit">{{ __('app.users.edit.department') }}</label>
            <div class="form-group">
              <select id="department_edit"class="form-control" name="department_edit" >
              @foreach ($departments as $department)
                 @if ($department->id==$user->department_id)
                    <option value="{{$department->id}}" name ="department_edit{{$department->id}}" selected>{{$department->description}}</option>
                 @else
                    <option value="{{$department->id}}" name ="department_edit{{$department->id}}" >{{$department->description}}</option>
                 @endif
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
            <button type="button" onclick="ajaxUpdate() "id="EditSubmit" class="btn btn-success">{{ __('app.buttons.update') }}</button>             
         </form>
            
        </div>
    </div> 
</div>
@include('partials.alertModal')
<script>
var ldap={{env("use_LDAP")}}
</script>

@stop