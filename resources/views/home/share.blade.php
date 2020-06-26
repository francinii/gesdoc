<div class="modal fade" id="share">
    <input id ="stepId" type="hidden" value="">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 id= "card-title" class="text-center">{{ __('app.home.share.share') }}</h2>
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body" id = "modal-body-share">
            <div class="step">
                <div class="card container inside_step " style="margin-bottom:1%">   
                    <div id = "" class="card-body">
                        <div id = "create">                             
                        <form class="" action="" method="POST">
                            {{csrf_field()}}                             
                            <div class="form-group">
                                <input id="owner" style="display:none">
                                <input id="documentsId" style="display:none">
                                <label class="control-label" for="searchUser">{{ __('app.home.share.shareWithUser') }}</label>                                                        
                                <select id='select_document' class="form-control selectpicker"  data-live-search="true" multiple >                
                                @foreach ($departments as $department)                                                            
                                <optgroup label="{{$department->description}}" >      
                                    @foreach ($department->users as $user)                                        
                                        <option data-tokens = "{{$department->description}}" id = "{{$user->username}}" value = "{{$user->email}}">{{$user->name}}</option>                                      
                                    @endforeach  
                                </optgroup>   
                                @endforeach                                    
                                </select>                           
                              </div>           
                              <table id='tablelist' class="table table-responsive table-striped" style="display:table">
                                <thead class="head_table thead-dark ">   
                                    <th>{{ __('app.home.share.user') }}</th>    
                                    <th>{{ __('app.home.share.name') }}</th>      
                                    <th>{{ __('app.home.share.email') }}</th>                                     
                                    <th>{{ __('app.home.share.delete') }}</th>             
                                </thead>
                                <tbody class="body_table" >              
                                </tbody>
                              </table>

                         </form>
                         <div class="form-group">
                            <button id="showPermission" class ='btn btn-primary' onclick= "openPermissions({{$actions}}) "   type ='button' >
                                <i class='fas fa-lock-open'>
                                </i> 
                                {{ __('app.home.share.AsociatePermission') }}
                                
                            </button>
                         </div>
                        </div>
                    </div>
                </div>    
            </div>        
        </div>
        <div class="modal-body" id = "modal-body-share-back" style="display:none">
            <button class="btn btn-info" onclick="backShareUsers()" > <i class= "fas fa-arrow-left"></i></button>
            <div class="card container inside_step " style="padding:1%">                
                <table id='tableLine' class="table table-responsive table-striped" style="display:table">
                <thead class="head_table thead-dark ">   
                        <th>{{ __('app.home.share.user') }}</th>
                        <th id="shareOwner">{{ __('app.home.share.owner') }}</th>
                        @foreach ($actions as $action) 
                         @if ($action->id != 4)             
                            <th id = "share-{{$action->id}}" >{{$action->description}}</th>
                            @endif
                        @endforeach             
                </thead>
                <tbody class="body_table_line" >    
                    
                </tbody>
                </table>
            </div>     
        </div>

        <div class="modal-footer">     
            <div class="col-md-9 text-right">
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="AjaxShare()" data-target="">
                    <i class="fas fa-plus-circle"></i> Guardar
                </button>    
              </div>  
        </div>
      </div>
   </div>
  </div>
      



