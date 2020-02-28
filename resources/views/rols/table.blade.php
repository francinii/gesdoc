<table id='table' class="table table-responsive table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Id</th>
                    <th >Descripcion del Rol</th>
                    <th>Modificar Rol</th>
                    <th>Eliminar Rol</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($rols as $rol)
                <tr>
                    <td class="">{{$rol->id}}</td>
                    <td class="">{{$rol->description}}</td>
                    <td class="">
                            <button onclick = "edit('{{$rol->id}}', '{{$rol->description}}' )"  class="btn btn-info"  data-toggle="modal" class=" float-right btn btn-success " >Editar</button>
                    </td>
                    <td class="">
                        <form method="POST" action="{{url('/rols/'.$rol->id)}}">
                            <button type="button" onclick="ajaxDelete({{$rol->id}})"  class=" btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
 </table>
