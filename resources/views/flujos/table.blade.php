<table id='table' class="table table-responsive table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th class="col-1 text-center">Id</th>
            <th class="col-6 text-center">Descripcion del Flujo</th>
            <th class="col-3 text-center">Creado por</th>                    
            <th class="col-1 text-center">Modificar Flujo</th>
            <th class="col-1 text-center">Eliminar Flujo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($flujos as $flujo)         
        <tr>
            <td class="col-1 text-center">{{$flujo->id}}</td>
            <td class="col-7 text-center">{{$flujo->description}}</td>
            @foreach($users as $user)
            
                @if($flujo->userId == $user->id )
                    <?php $usuario =  $user->id ?>
                    <td id="usuarioId" class="col-2 text-center">{{$user->name}}</td>
                    @break
                @endif
            @endforeach                                         
            <td class="col-1 text-center">
                    <button onclick = "edit('{{$flujo->id}}', '{{$flujo->description}}','{{$usuario}} ')"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>
            </td>
            <td class="col-1 text-center">
                <form method="POST" action="{{url('/flujos/'.$flujo->id)}}">
                    <button type="button" onclick="ajaxDelete({{$flujo->id}} ,'flujos','table')"  class=" btn btn-danger">
                        <i class="fas fa-trash-alt">
                        </i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>
