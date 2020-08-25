<div class="modal fade" id="permissionModalS">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h5>  {{ __('app.flows.permission.title') }} </h5>
          <button type="close" class="close" data-dismiss="modal"> X</button>
        </div>       
        <div class="modal-body">            
            <div class="form-group">   
                <label for="idPermissionModal"> {{ __('app.flows.permission.step') }}</label>                                                                     
                <select id='idPermissionModal' onchange="permissionModalTable({{$flow->id}},{{$actions}})" class="form-control" >  
                    @foreach ($steps as $step) 
                    {{$dragable_inicio =  __('app.global.draggable_inicio') }}
                    {{$dragable_final =  __('app.global.draggable_final') }}
                    @if($step->id !=  $dragable_inicio && $step->id != $dragable_final )   
                        <option value="{{$step->id}}">{{$step->description}}</option>
                    @endif   
                    @endforeach                                  
                </select>                           
            </div>    
            <div id ='permtable'>          
                @include('flows.permissionTable')
            </div>
        </div>     
        <div class="modal-footer">     
            <div class="col-md-9 text-right">          
                <span>
                    <button data-toggle="modal" class=" float-right btn btn-success" onclick="savePermissionsModal({{$flow->id}},0)" data-target="">
                        <i class="fas fa-save"></i> {{ __('app.flows.permission.save') }}
                    </button> 
                    <span>&nbsp;</span> 
                </span>
                <span>
                    <button data-toggle="modal" class=" float-right btn btn-warning" onclick="savePermissionsModal({{$flow->id}},1)" data-target="">
                        <i class="fas fa-save"></i> {{ __('app.flows.permission.saveClose') }}
                    </button>   
                    <span>&nbsp;</span> 
                </span>
            </div>  
        </div>
      </div>
    </div>
</div>

      



