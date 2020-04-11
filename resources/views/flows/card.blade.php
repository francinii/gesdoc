    
<div id = "accordion" class="step fade">
    <div class="card container inside_step " style="margin-bottom:1%">
        <div class="card-header bg-dark row">     
            <a class="h5 col-md-11 text-white step-description" data-toggle="collapse" data-parent="#accordion" href="#collapse1">Collapsible Group 1</a>
            <div  class="col-md-1 justify-content-right"> 
                <button onclick="deleteStep(this)" type="button"  class="btn btn-danger">
                    <i  class="fa fa-trash"></i>
                </button>
            </div>     
        </div>

        <div id = "collapse1"class="card-body panel-collapse collapse in">
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
 