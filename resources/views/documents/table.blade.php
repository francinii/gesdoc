<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width: 10%"  class="text-center">{{ __('app.documents.table.id') }}</th>
            <th style="width: 50%"  class="text-center">{{ __('app.documents.table.description') }}</th>
            <th style="width: 20%"  class="text-center">{{ __('app.documents.table.flow') }}</th>                    
            <th style="width: 10%"  class="text-center">{{ __('app.documents.table.edit') }}</th>
            <th  style="width: 10%"  class="text-center">{{ __('app.documents.table.delete') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($documents as $document)         
        <tr>
            <td class="text-center">{{$document->id}}</td>
            <td class="text-center">{{$document->description}}</td>
            @foreach($flows as $flow)
            
                @if($document->flow_id == $flow->id )
                    <?php 
                    $flowId =  $flow->id;
                     ?>
                    <td id="usuarioId" class="text-center">{{$flow->description}}</td>
                    @break
                @endif
            @endforeach                                         
            <td class="text-center">
                    <button onclick = "edit('{{$document->id}}', '{{$document->description}}','{{$flowId}}')"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>
            </td>
            <td class="text-center">
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
