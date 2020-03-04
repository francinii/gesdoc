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
                @foreach ($rols as $rol)         
                <tr>
                    <td class="col-1 text-center">{{$rol->id}}</td>
                    <td class="col-7 text-center">{{$rol->description}}</td>
                    <td class="col-1 text-center"> 
                        
                        
                        <?php
                            //Listando los permisos de un rol especifico
                             $rolp = App\Rol::find($rol->id) ;
                             $permisosAsociados = $rolp->permisos;
                          //   echo $rolp->users;
                        ?>

                    
                        <button onclick = "list({{ $permisosAsociados}}, '{{$rol->description}}',1)"  class="btn btn-primary"  data-toggle="modal">
                           <i class="fas fa-lock-open">
                           </i>
                       </button>
                   </td>
                    <td class="col-1 text-center">         
                         <button onclick = "list({{$rol->users}}, '{{$rol->description}}',2 )"  class="btn btn-info"  data-toggle="modal">
                            <i class="fas fa-user">
                            </i>
                        </button>
                    </td>
                    <td class="col-1 text-center">
                            <button onclick = "edit('{{$rol->id}}', '{{$rol->description}}', {{$permisos}},{{ $permisosAsociados}} )"  class="btn btn-success"  data-toggle="modal" >
                                <i class="fas fa-edit"></i>
                            </button>
                    </td>
                    <td class="col-1 text-center">
                        <form method="POST" action="{{url('/rols/'.$rol->id)}}">
                            <button type="button" onclick="ajaxDelete({{$rol->id}} ,'rols','table')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
 </table>
