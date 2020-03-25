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
        @foreach ($flows as $flow)         
        <tr>
            <td class="col-1 text-center">{{$flow->id}}</td>
            <td class="col-7 text-center">{{$flow->description}}</td>
            @foreach($users as $user)
            
                @if($flow->user_id == $user->id )
                    <?php $usuario =  $user->id ?>
                    <td id="usuarioId" class="col-2 text-center">{{$user->name}}</td>
                    @break
                @endif
            @endforeach                                         
            <td class="col-1 text-center">
                    <button onclick = "edit('{{$flow->id}}', '{{$flow->description}}','{{$usuario}} ')"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>
            </td>
            <td class="col-1 text-center">
                <form method="POST" action="{{url('/flows/'.$flow->id)}}">
                    <button type="button" onclick="ajaxDelete({{$flow->id}} ,'flows','table')"  class=" btn btn-danger">
                        <i class="fas fa-trash-alt">
                        </i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>
