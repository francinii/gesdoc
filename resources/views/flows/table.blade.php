<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width: 10%"  class="text-center">{{ __('app.flows.table.id') }}</th>
            <th style="width: 20%"  class="text-center">{{ __('app.flows.table.description') }}</th>            
            <th style="width: 20%"  class="text-center">{{ __('app.flows.table.owner') }}</th>  
            <th style="width: 15%"  class="text-center">Estado</th>       
            <th style="width: 10%"  class="text-center">Permisos</th>           
            <th style="width: 10%"  class="text-center">Ver/Editar Flujo</th>
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
                        <option id= "inactive{{$flow->id}}"  value = "0" selected >Inactivo</option>
                    @else 
                        <option id= "inactive{{$flow->id}}"  value = "0">Inactivo</option>
                    @endif
                    @if($flow->state == 1)
                        <option id= "active{{$flow->id}}"  value = "1" selected>Activo</option>
                    @else 
                        <option id= "active{{$flow->id}}"  value = "1">Activo</option>
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
