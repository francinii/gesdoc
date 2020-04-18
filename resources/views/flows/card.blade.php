<div class="modal fade" id="card">
    <div class="modal-dialog  modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 class="text-center">Editar Paso</h2>
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body">
            <div id = "" class="step">
                <div class="card container inside_step " style="margin-bottom:1%">   
                    <div id = "" class="card-body">
                        <div id = "create">                             
                        <form class="" action="" method="POST">
                            {{csrf_field()}}
                            <div class="form-group ">
                                <label class="control-label col-md-4" for="CreateDescription"> Descripción del Paso</label>
                                <input type="text" class="form-control " id="CreateDescription" placeholder="Descripcion" name="CreateDescription">
                            </div>                                      
                              
                            <div class="form-group">
                                <label class="control-label" for="searchUser">Usuarios asociados</label>                                                       
                              
                                <select id='select_document' class="form-control selectpicker"  data-live-search="true" multiple >                 
                                    <optgroup label="Picnic" >                                     
                                    @foreach ($users as $user)
                                        <option id = "{{$user->username}}" value = "{{$user->email}}">{{$user->name}}</option>
                                    @endforeach  
                                    </optgroup>
                                     
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
                            <button type="button" id="CreateSubmit" onclick="ajaxCreate({{ Auth::user()->id }})" class="btn btn-success">{{ __('app.buttons.add') }}</button>
                        </form>
                        </div>
                    </div>
                </div>    
            </div>        
        </div>
        <div class="modal-footer">     
            <div class="col-md-9 text-right">
                <button data-toggle="modal" class=" float-right btn btn-success" onclick="addUsers()" data-target="">
                    <i class="fas fa-plus-circle"></i> {{ __('app.buttons.add') }}
                </button>    
              </div>  
        </div>
      </div>
   </div>
  </div>
      



