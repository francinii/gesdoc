<table id='table' class="table table-responsive table-striped">
            <thead class="thead-dark">
                <tr class="">
                    <th class="col-2 text-center">Usuario</th>
                    <th class="col-4 text-center">Nombre</th>                    
                    <th class="col-2 text-center">Correo</th>
                    <th class="col-3 text-center">Rol Asociado</th>                    
                    <th class="col-1 text-center">Eliminar Usuario</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($users as $user)
                <tr>
                    <td class="col-2 text-center">{{$user->username}}</td>
                    <td class="col-4 text-center">{{$user->name}}</td>
                    <td class="col-2 text-center">{{$user->email}}</td>
                    <td class="col-3 text-center">                        
                        <div class="form-group">
                            <select class="form-control" name="rol" >
                               @foreach($rols as $rol)
                                    @if($user->rol_id == $rol->id )
                                        <option value="{{$rol->id}}" name ="{{$rol->id}}" selected>{{$rol->description}}</option>
                                    @else
                                        <option value="{{$rol->id}}" name ="{{$rol->id}}">{{$rol->description}}</option>
                                    @endif
                               @endforeach
                             </select>
                           </div>
                        
                    </td>       
                    <td class="col-1 text-center">
                        
                            <button type="button" onclick="ajaxDelete({{$user->id }}  ,'users')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>
                      
                    </td>
                </tr>
                @endforeach
            </tbody>
 </table>
