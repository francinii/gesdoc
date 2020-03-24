<table id='table' class="table table-responsive table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th class="col-1 text-center">Id</th>
            <th class="col-6 text-center">Descripcion del Documento</th>
            <th class="col-3 text-center">Flujo al que pertenece</th>                    
            <th class="col-1 text-center">Modificar Flujo</th>
            <th class="col-1 text-center">Eliminar Flujo</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($documentos as $documento)         
        <tr>
            <td class="col-1 text-center">{{$documento->id}}</td>
            <td class="col-7 text-center">{{$documento->description}}</td>
            @foreach($flujos as $flujo)
            
                @if($documento->flujoId == $flujo->id )
                    <?php $flujoId =  $flujo->id ?>
                    <td id="usuarioId" class="col-2 text-center">{{$flujo->description}}</td>
                    @break
                @endif
            @endforeach                                         
            <td class="col-1 text-center">
                    <button onclick = "edit('{{$documento->id}}', '{{$documento->description}}','{{$flujoId}} ')"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>
            </td>
            <td class="col-1 text-center">
                <form method="POST" action="{{url('/documento/'.$documento->id)}}">
                    <button type="button" onclick="ajaxDelete({{$documento->id}} ,'documentos','table')"  class=" btn btn-danger">
                        <i class="fas fa-trash-alt">
                        </i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>
