<table id='table' class="table table-striped" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th  style="width: 10%" class="text-center">{{ __('app.users.table.user') }}</th>
                    <th  style="width: 20%" class="text-center">{{ __('app.users.table.name') }}</th>                    
                    <th  style="width: 20%" class="text-center">{{ __('app.users.table.email') }}</th>
                    <th  style="width: 20%"  class="text-center">{{ __('app.users.table.role') }}</th>
                    <th  style="width: 10%" class="text-center">{{ __('app.users.table.edit') }}</th>                   
                    <th  style="width: 10%" class="text-center">{{ __('app.users.table.delete') }}</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($users as $user)
                <tr>
                    <td class=" text-center">{{$user->username}}</td>
                    <td class=" text-center">{{$user->name}}</td>
                    <td class=" text-center">{{$user->email}}</td>                              
                        @foreach($roles as $role)
                            @if($user->role_id == $role->id )
                                <td class=" text-center">{{$role->description}}</td>
                                @break
                            @endif
                        @endforeach                  
                     
                    <td class=" text-center">
                        <button onclick = "edit('{{$user->username}}', '{{$user->email}}', '{{$user->name}}', '{{$user->role_id}}','{{$user->department_id}}')"  class="btn btn-success"  data-toggle="modal" >
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>    
                    <td class=" text-center">                        
                            <button type="button" onclick="confirmDelete({{$user->username }}  ,'users','table-divTable','¿Desea eliminar a {{$user->name}}?')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>                      
                    </td>                    
                </tr>
                @endforeach
            </tbody>

 </table>
 <script>
    $( document ).ready(function() {
         var js_data = '<?php echo json_encode($notifications); ?>';        
         var notifications=JSON.parse(js_data );
         updateNotifications(notifications)
    });
</script>
