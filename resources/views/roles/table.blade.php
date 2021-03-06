<table id='table' class="table table-striped" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr class="">
                    <th style="width: 10%"  class="text-center">{{ __('app.roles.table.id') }}</th>
                    <th style="width: 40%"  class="text-center">{{ __('app.roles.table.description') }}</th>
                    <th style="width: 10%"  class="text-center">{{ __('app.roles.table.permission') }}</th>
                    <th style="width: 10%"  class="text-center">{{ __('app.roles.table.user') }}</th>
                    <th style="width: 10%"  class="text-center">{{ __('app.roles.table.edit') }}</th>
                    <th style="width: 10%"  class="text-center">{{ __('app.roles.table.delete') }}</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($roles as $role)         
                <tr class="">
                    <td class="text-center">{{$role->id}}</td>
                    <td class="text-center">{{$role->description}}</td>
                    <td class=" text-center"> 
                        
                        
                        <?php
                        $rolep = App\Role::find($role->id) ;
                        $permissionsAsociados = $rolep->permissions;                          
                        ?>

                        <button onclick = "list({{ $permissionsAsociados}}, '{{$role->description}}',1)"  class="btn btn-primary"  data-toggle="modal">
                           <i class="fas fa-lock-open">
                           </i>
                       </button>
                   </td>
                    <td class="text-center">         
                         <button onclick = "list({{$role->users}}, '{{$role->description}}',2 )"  class="btn btn-info"  data-toggle="modal">
                            <i class="fas fa-user">
                            </i>
                        </button>
                    </td>
                    <td class="text-center">
                        @if($role->id != 1)  <!--1 correspond to the super admin role -->
                            <button onclick = "edit('{{$role->id}}', '{{$role->description}}', {{ $permissionsAsociados}} )"  class="btn btn-success"  data-toggle="modal" >
                                <i class="fas fa-edit"></i>
                            </button>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($role->id != 1)  <!--1 correspond to the super admin role -->
                        <form method="POST" action="{{url('/roles/'.$role->id)}}">
                            <button type="button" onclick="confirmDelete({{$role->id}} ,'roles','table-divTable', '¿Desea eliminar el rol: {{$role->description}}?')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>
                        </form>
                        @endif
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
