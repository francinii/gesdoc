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
                            <div class="form-group row">
                                <label class="control-label col-2" for="CreateDescription"> Descripción </label>
                                <input type="text" class="form-control col-10" id="CreateDescription" placeholder="Descripcion" name="CreateDescription">
                            </div> 
                            <div class="form-group row">
                                <label class="control-label" for="searchUser">Usuarios asociados</label>                                                       
                                <button  type="button"  data-target="#list" data-toggle="modal" id="UserSubmit" onclick="" class="btn btn-info">
                                    <i class="fa fa-search"></i>
                                </button>               
                            </div>                       
                            <table id='table' class="table table-striped">
                                <thead class="thead-dark">
                                    <tr class="">
                                        <th style="width: 20%"  class="text-center">{{ __('app.flows.table.id') }}</th>
                                        <th style="width: 20%"  class="text-center">{{ __('app.flows.table.description') }}</th>
                                        <th style="width: 20%"  class="text-center">{{ __('app.flows.table.owner') }}</th>                    
                                        <th style="width: 20%"  class="text-center">{{ __('app.flows.table.edit') }}</th>
                                        <th style="width: 20%"  class="text-center">{{ __('app.flows.table.delete') }}</th>
                                    </tr>
                                </thead>
                                <tbody>                            
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

        </div>
      </div>
   </div>
  </div>
      



