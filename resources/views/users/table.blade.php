<table id='table' class="table table-responsive table-striped">
            <thead class="thead-dark">
                <tr class="">
                    <th class="col-2 text-center">Usuario</th>
                    <th class="col-3 text-center">Nombre</th>                    
                    <th class="col-3 text-center">Correo</th>
                    <th class="col-2 text-center">Rol Asociado</th>
                    <th class="col-1 text-center">Editar usuario</th>                   
                    <th class="col-1 text-center">Eliminar Usuario</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($users as $user)
                <tr>
                    <td class="col-2 text-center">{{$user->username}}</td>
                    <td class="col-3 text-center">{{$user->name}}</td>
                    <td class="col-3 text-center">{{$user->email}}</td>                              
                        @foreach($rols as $rol)
                            @if($user->rol_id == $rol->id )
                                <td class="col-2 text-center">{{$rol->description}}</td>
                                @break
                            @endif
                        @endforeach           
                        
                     
                    <td class="col-1 text-center">
                        <button onclick = "edit('{{$user->id}}','{{$user->username}}', '{{$user->email}}', '{{$user->name}}', '{{$user->rol_id}}', {{$rols}}  )"  class="btn btn-info"  data-toggle="modal" >
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>    
                    <td class="col-1 text-center">
                        
                            <button type="button" onclick="ajaxDelete({{$user->id }}  ,'users','table')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>
                      
                    </td>
                    
                </tr>
                @endforeach
            </tbody>
 </table>
