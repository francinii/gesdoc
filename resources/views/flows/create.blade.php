<div class="container-fluid " id = "create-wrapper"  style="display:none">    
    <div class="row  justify-content-center">         
        <div  class="col-md-11">
          <div class="float-lg-left">                
          </div>          
        </div>
        <div  class="col-md-11 container">
          <div class="form-group row">
              <label class="control-label col-2" for="flowName"> {{ __('app.flows.create.name') }} </label>
              <input type="text" class="form-control col-10" id="flowName" placeholder="{{ __('app.flows.create.name') }}" name="flowName">
          </div> 
        </div> 
        <div class="col-md-11">
            <button  type="button" id="CreateSubmit" onclick="confirm('Todo el progreso se borrará si no ha sido guardado. ¿Desea salir del modo edición?  ')" class="btn btn-success ml-auto">
              <i class="fas fa-arrow-left"></i>
            </button> 
            <button type="button" class="btn btn-primary float-right" onclick="ajaxCall('{{ Auth::user()->username }}')">
              <i class="fas fa-plus-circle"> </i>
              Guardar flujo
            </button>
            <button type="button" class="btn btn-danger float-right" onclick="createStartEnd('draggable_final','Fin', 'bg-danger')">
              <i class="fas fa-plus-circle"> </i>
              Agregar final
            </button>
            <button type="button" class="btn btn-info float-right" onclick="createStep({{$actions}})">
              <i class="fas fa-plus-circle"> </i>
              Agregar departamento
            </button>
            <button type="button" class="btn btn-success float-right" onclick="createStartEnd('draggable_inicio', 'Inicio', 'bg-success')">
              <i class="fas fa-plus-circle"> </i>
              Agregar inicio
            </button> 
        </div>
        <div class="col-md-10">&nbsp;</div>
        <div id = "steps" class="col-10" >              
        </div>              
    </div> 
    <!--Inicio del flujo de trabajo -->   
    <div class="row justify-content-center">  
      <div class="col-11" id= 'drag-container'  >         
      </div>
    </div>    
</div>


