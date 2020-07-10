         
<div class="form-group">
  <label class="control-label" for="">Agregar usuario</label>                                                        
  <select id='selectUserPermission' class="form-control"  data-live-search="true" multiple >                
      @foreach ($departments as $department)                                                            
          <optgroup label="{{$department->description}}" >      
              @foreach ($allusers as $user)
                  @if($user->department_id == $department->id)
                      @if(in_array( $user->username, $usersArray))
                          <option id = '{{$user->username}}'data-tokens = "{{$department->description}}" id = "{{$user->username}}" selected value = "{{$user->email}}">{{$user->name}}</option>
                      @else
                          <option id = '{{$user->username}}'data-tokens = "{{$department->description}}" id = "{{$user->username}}" value = "{{$user->email}}">{{$user->name}}</option>
                      @endif 
                  @endif 
              @endforeach  
          </optgroup>   
      @endforeach                                    
  </select>                           
</div>
<table id='tablePermission' class="table table-responsive table-striped" style="display:table">
    <thead class="head_table thead-dark ">        
        <th>Usuario</th> 
        <th>Nombre</th>   
    
        @foreach ($actions as $action)      
          @if ($action->type == 0  || $action->type == 1 )                
              <th id = "{{$action->id}}" >{{$action->description}}</th>
          @endif           
        @endforeach 
        <th>Quitar permisos</th>

    </thead>
    <tbody id = 'body_table_permission' class="body_table_permission" style="text-align: center">     
      @foreach ($users as $user) 
      <?php     
       $actSteUs = $actionStepUser->where('username', '=', $user->username)->pluck('action_id')->toArray();
      ?>    
        <tr id ='body_table_permission{{$user->username}}'>         
          <td id = "{{$user->username}}" >{{$user->username}}</td> 
          <td id = "{{$user->name}}" >{{$user->name}}</td>           
          @foreach ($actions as $action)   
          @if ($action->type == 0  || $action->type == 1 )    
              @if(in_array( $action->id, $actSteUs) )
                  <td ><input id = "{{$action->id}}" type ="checkbox" class="form-check-input"checked></td>  
                  
              @else     
                  <td ><input  id = "{{$action->id}}"  type ="checkbox" class="form-check-input" ></td>  
              @endif  
          @endif           
          @endforeach
          <td><button class ='btn btn-danger delete' onclick="deleteUserTable('body_table_permission' , '{{$user->username}}' , 'selectUserPermission')" type ='button' ><i class='fas fa-trash-alt'></i></button></td>
         
      </tr> 
      @endforeach  
    </tbody>
</table> 
         