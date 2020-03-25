<table id='table' class="table table-responsive table-striped" cellspacing="0" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th  class="text-center">Usuario</th>
                    <th  class="col-md-1  text-center">Nombre</th>                    
                    <th  class="col-md-1  text-center">Correo</th>
                    <th   class=" text-center">Rol Asociado</th>
                    <th  class=" text-center">Editar usuario</th>                   
                    <th  class=" text-center">Eliminar Usuario</th>
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
                        <button onclick = "edit('{{$user->id}}','{{$user->username}}', '{{$user->email}}', '{{$user->name}}', '{{$user->role_id}}','{{$user->department_id}}')"  class="btn btn-info"  data-toggle="modal" >
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>    
                    <td class=" text-center">                        
                            <button type="button" onclick="confirmarDelete({{$user->id }}  ,'users','table','Desea eliminar a {{$user->name}}?')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>                      
                    </td>                    
                </tr>
                @endforeach
            </tbody>
 </table>
