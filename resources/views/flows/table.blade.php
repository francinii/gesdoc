<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.id') }}</th>
            <th style="width: 20%"  class="text-center">{{ __('app.flows.table.description') }}</th>            
            <th style="width: 20%"  class="text-center">{{ __('app.flows.table.owner') }}</th>  
            <th style="width: 15%"  class="text-center">{{ __('app.flows.table.state') }}</th>       
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.permission') }}</th>   
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.clone') }}</th>        
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.editSee') }}</th>
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.delete') }}</th>
        </tr>
    </thead>
    <tbody>
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
                <div class="form-group">                                                                        
                <select id='selectFlow{{$flow->id}}' onchange="activeFlowModal(this, 'selectFlow{{$flow->id}}', '{{$flow->id}}')" class="form-control"   >                
                    @if($flow->state == 0)   
                        <option id= "inactive{{$flow->id}}"  value = "0" selected >  {{ __('app.flows.table.stateInactive') }} </option>
                    @else 
                        <option id= "inactive{{$flow->id}}"  value = "0">{{ __('app.flows.table.stateInactive') }}</option>
                    @endif
                    @if($flow->state == 1)
                        <option id= "active{{$flow->id}}"  value = "1" selected>{{ __('app.flows.table.stateActive') }}</option>
                    @else 
                        <option id= "active{{$flow->id}}"  value = "1">{{ __('app.flows.table.stateActive') }}</option>
                    @endif                                                  
                </select>                           
            </div>   
            </td>
           <td class=" text-center">                   
                <button onclick=" permissionModal({{$flow->id}},{{$filterActions}})" class="btn btn-primary" data-toggle="modal">
                   <i class="fas fa-lock-open">
                   </i>
               </button>
           </td>
           <td class="text-center">

                    <button title ="Clonar" onclick = "ajaxCloneFlow('{{$flow->id}}')"  class="btn btn-warning"  data-toggle="modal" >
                        <i class="far fa-clone"></i>
                    </button>  
            </td>

            <td class="text-center">
                @if($flow->state == 0)     
                    <button title ="Editar flujo" onclick = "ajaxEdit('{{$flow->id}}', '{{$flow->description}}',0)"  class="btn btn-success"  data-toggle="modal" >
                        <i class="fas fa-edit"></i>
                    </button>  
                @else
                    <button title ="Ver flujo" onclick = "ajaxEdit('{{$flow->id}}', '{{$flow->description}}',1)"  class="btn btn-info"  data-toggle="modal" >
                        <i class="fas fa-eye"></i>
                    </button>
                @endif
            </td>
            <td class="text-center">
                @if($flow->state == 0)  
                <form method="POST" action="{{url('/flows/'.$flow->id)}}">
                    <button type="button" onclick="confirmDelete({{$flow->id}} ,'flows','table-divTable','¿Desea eliminar el flujo: {{$flow->description}}?')"  class=" btn btn-danger">
                        <i class="fas fa-trash-alt">
                        </i>
                    </button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>
 <script>
    $( document ).ready(function() {
         var js_data = '<?php echo json_encode($notifications); ?>';        
         var notifications=JSON.parse(js_data );
         updateNotifications(notifications)
    });
</script>