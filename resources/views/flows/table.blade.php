<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.id') }}</th>
            <th style="width: 50%"  class="text-center">{{ __('app.flows.table.description') }}</th>
            <th style="width: 20%"  class="text-center">{{ __('app.flows.table.owner') }}</th>                    
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.edit') }}</th>
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.delete') }}</th>
        </tr>
    </thead>
    <tbody>
        <?php $usuario = ''?>
        @foreach ($flows as $flow)         
        <tr>
            <td class="text-center">{{$flow->id}}</td>
            <td class="text-center">{{$flow->description}}</td>
            @foreach($users as $user)
            
                @if($flow->username == $user->username )
                    <?php $usuario =  $user->username ?>
                    <td id="usuarioId" class="text-center">{{$user->name}}</td>
                    @break
                @endif
            @endforeach                                         
            <td class="text-center">
                    <button onclick = "edit('{{$flow->id}}', '{{$flow->description}}','{{$usuario}} ')"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>
            </td>
            <td class="text-center">
                <form method="POST" action="{{url('/flows/'.$flow->id)}}">
                    <button type="button" onclick="confirmDelete({{$flow->id}} ,'flows','table','¿Desea eliminar el flujo: {{$flow->description}}?')"  class=" btn btn-danger">
                        <i class="fas fa-trash-alt">
                        </i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>
