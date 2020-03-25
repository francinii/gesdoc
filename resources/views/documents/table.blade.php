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
        @foreach ($documents as $document)         
        <tr>
            <td class="col-1 text-center">{{$document->id}}</td>
            <td class="col-7 text-center">{{$document->description}}</td>
            @foreach($flows as $flow)
            
                @if($document->flow_id == $flow->id )
                    <?php 
                    $flowId =  $flow->id;
                     ?>
                    <td id="usuarioId" class="col-2 text-center">{{$flow->description}}</td>
                    @break
                @endif
            @endforeach                                         
            <td class="col-1 text-center">
                    <button onclick = "edit('{{$document->id}}', '{{$document->description}}','{{$flowId}}')"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>
            </td>
            <td class="col-1 text-center">
                <form method="POST" action="{{url('/document/'.$document->id)}}">
                    <button type="button" onclick="confirmDelete({{$document->id}} ,'documents','table', '¿Desea eliminar el documento: {{$document->description}}?')"  class=" btn btn-danger">
                        <i class="fas fa-trash-alt">
                        </i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>
