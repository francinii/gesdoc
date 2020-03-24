<table id='table' class="table table-responsive table-striped">
            <thead class="thead-dark">
                <tr class="">
                    <th class="col-1 text-center">Id</th>
                    <th class="col-7 text-center">Descripcion del Rol</th>
                    <th class="col-1 text-center">Permisos asociados</th>
                    <th class="col-1 text-center">Usuarios asociados</th>
                    <th class="col-1 text-center">Modificar Rol</th>
                    <th class="col-1 text-center">Eliminar Rol</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($roles as $role)         
                <tr>
                    <td class="col-1 text-center">{{$role->id}}</td>
                    <td class="col-7 text-center">{{$role->description}}</td>
                    <td class="col-1 text-center"> 
                        
                        
                        <?php
                            //Listando los permisos de un rol especifico
                             $rolep = App\Role::find($role->id) ;
                             $permissionsAsociados = $rolep->permissions;
                          //   echo $rolp->users;
                        ?>

                    
                        <button onclick = "list({{ $permissionsAsociados}}, '{{$role->description}}',1)"  class="btn btn-primary"  data-toggle="modal">
                           <i class="fas fa-lock-open">
                           </i>
                       </button>
                   </td>
                    <td class="col-1 text-center">         
                         <button onclick = "list({{$role->users}}, '{{$role->description}}',2 )"  class="btn btn-info"  data-toggle="modal">
                            <i class="fas fa-user">
                            </i>
                        </button>
                    </td>
                    <td class="col-1 text-center">
                            <button onclick = "edit('{{$role->id}}', '{{$role->description}}', {{$permissions}},{{ $permissionsAsociados}} )"  class="btn btn-success"  data-toggle="modal" >
                                <i class="fas fa-edit"></i>
                            </button>
                    </td>
                    <td class="col-1 text-center">
                        <form method="POST" action="{{url('/roles/'.$role->id)}}">
                            <button type="button" onclick="ajaxDelete({{$role->id}} ,'roles','table')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
 </table>
