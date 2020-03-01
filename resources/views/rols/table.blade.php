<table id='table' class="table table-responsive table-striped">
            <thead class="thead-dark">
                <tr class="">
                    <th class="col-1 text-center">Id</th>
                    <th class="col-5 text-center">Descripcion del Rol</th>
                    <th class="col-2 text-center">Usuarios asociados</th>
                    <th class="col-2 text-center">Modificar Rol</th>
                    <th class="col-2 text-center">Eliminar Rol</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($rols as $rol)
                <tr>
                    <td class="col-1 text-center">{{$rol->id}}</td>
                    <td class="col-5 text-center">{{$rol->description}}</td>
                    <td class="col-2 text-center">         
                         <button onclick = "edit('{{$rol->id}}', '{{$rol->description}}' )"  class="btn btn-info"  data-toggle="modal">
                            <i class="fas fa-user">
                            </i>
                        </button>
                    </td>
                    <td class="col-2 text-center">
                            <button onclick = "edit('{{$rol->id}}', '{{$rol->description}}' )"  class="btn btn-success"  data-toggle="modal" >
                                <i class="fas fa-edit"></i>
                            </button>
                    </td>
                    <td class="col-2 text-center">
                        <form method="POST" action="{{url('/rols/'.$rol->id)}}">
                            <button type="button" onclick="ajaxDelete({{$rol->id}})"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
 </table>
