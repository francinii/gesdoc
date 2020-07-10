<div class="modal fade" id="card">
    <input id ="stepId" type="hidden" value="">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 id= "card-title" class="text-center"></h2>
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body" id = "modal-body-step">
            <div class="step">
                <div class="card container inside_step " style="margin-bottom:1%">   
                    <div id = "" class="card-body">
                        <div id = "create">                             
                        <form class="" action="" method="POST">
                            {{csrf_field()}}
                            <div class="form-group ">
                                <label class="control-label" for="CreateDescription"> Descripción del Departamento</label>
                                <input type="text" class="form-control " id="CreateDescription" placeholder="Descripcion" name="CreateDescription">
                            </div>                         
                            <div class="form-group">
                                <label class="control-label" for="searchUser">Usuarios asociados</label>                                                        
                                <select id='select_document' class="form-control selectpicker"  multiple data-selected-text-format="count" data-live-search="true" multiple >                
                                @foreach ($departments as $department)                                                            
                                <optgroup label="{{$department->description}}" >      
                                    @foreach ($users as $user)
                                        @if($user->department_id == $department->id)
                                        <option data-tokens = "{{$department->description}}" id = "{{$user->username}}" value = "{{$user->email}}">{{$user->name}}</option>
                                        @endif 
                                    @endforeach  
                                </optgroup>   
                                @endforeach                                    
                                </select>                           
                              </div>           
                              <table id='tablelist' class="table table-responsive table-striped" style="display:table">
                                <thead class="head_table thead-dark ">   
                                    <th>Usuario</th>    
                                    <th>Nombre</th>      
                                    <th>Correo</th>                                     
                                    <th>Eliminar</th>             
                                </thead>
                                <tbody class="body_table" >              
                                </tbody>
                              </table>

                         </form>
                         <div class="form-group">
                            <button class ='btn btn-primary' onclick= "openPermissions({{$actions}}) "   type ='button' >
                                <i class='fas fa-lock-open'>
                                </i> 
                                Asociar permisos a usuarios 
                            </button>
                         </div>
                        </div>
                    </div>
                </div>    
            </div>        
        </div>
        <div class="modal-body" id = "modal-body-step-back" style="display:none">
            <button class="btn btn-info" onclick="openStepEdition()" > <i class= "fas fa-arrow-left"></i></button>
            <div class="card container inside_step " style="padding:1%">    
                <div><h5>Asociar permisos a usuarios</h5></div>            
                <div id = "alertPermission" class="alert alert-dismissable" style="display: none">
                    <button type="button" class="close" onclick="hideAlert('alertPermission')">&times;</button>
                    <div id="alert-permission-content"> </div>    
                </div>
                <table id='tableLine' class="table table-responsive table-striped" style="display:table">
                <thead class="head_table thead-dark ">   
                        <th>Usuarios</th>    
                        @foreach ($actions as $action)      
                        @if ($action->type == 0  || $action->type == 1 )                
                        <th id = "{{$action->id}}" >{{$action->description}}</th>
                        @endif
                        @endforeach             
                </thead>
                <tbody class="body_table_line" >                         
                </tbody>
                </table>
                <div class="form-group">
                    <button data-toggle="modal" class=" float-right btn btn-success" onclick="savePermissions()" data-target="">
                        <i class="fas fa-plus-circle"></i> Guardar los permisos
                    </button>   
                </div>  
            </div>   
            
        </div>

        <div class="modal-footer">     
            <div class="col-md-9 text-right">
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="hideModalCardSave()" data-target="">
                    <i class="fas fa-plus-circle"></i> Guardar
                </button>    
              </div>  
        </div>
      </div>
   </div>
  </div>
      



