<?php $countActions = count($actions);?>
@if ($countActions>0)
  <div class="card " style="height: 80vh">
      <div class="card-header bg-danger ">
        <h5 class="card-title text-light">{{ __('app.documentFlow.actionHistory.title') }}  {{ $versionNum }}</h5>    
      </div>
      <div class="card-body" style = "height:100%;  overflow-y:scroll; padding:2%">      
        @foreach ($actions as $action)
          <div class="card">
            <div class="card-header ">
              <span><b class="card-text card-title "></b></span>
                      
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12">      
                      <div>
                        <span><b class="card-text ">{{ __('app.documentFlow.actionHistory.dateBegin') }} </b></span>
                        <span id = '' class="card-text">{{ $action->created_at }}</span> 
                      </div>
                      <div>            
                          <span><b class="card-text ">{{ __('app.documentFlow.actionHistory.dateUpdate') }} </b></span>
                          <span id = '' class="card-text">{{ $action->updated_at }}</span>
                      </div>
                      <div>            
                        <span><b class="card-text ">{{ __('app.documentFlow.actionHistory.responsable') }} </b></span>
                        <span id = '' class="card-text">  {{ $action->name_user }} con 
                          identificación  {{ $action->username }}
                        </span>
                      </div>                      
                      <div>            
                        <span><b class="card-text ">{{ __('app.documentFlow.actionHistory.description') }} </b></span>
                        <span class="card-text ">{{ $action->description }}   
                        
                        </span>   
                      </div>           
                    </div>  
                </div>
            </div>
          </div>
          <div>&nbsp;</div>   
        @endforeach
      </div>
  </div>
@else
  <div class="card-header ">
      <span><b class="card-text card-title ">{{ __('app.documentFlow.actionHistory.noInformation') }} </b></span>
  </div>
@endif

