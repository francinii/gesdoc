<div class="container-fluid" id = "create-wrapper"  style="display:none">    
    <div class="   staticPosition" >   
      <div class = "row  justify-content-center" style="background-color: white">
        <div class="col-md-10">
            <div class="float-lg-left">  </div>          
        </div>
        <div  class="col-md-10 container">         
          <div class="form-group row">            
              <label class="control-label col-2" for="flowName"> {{ __('app.flows.create.name') }} </label>
              <input type="text" class="form-control col-10" id="flowName" placeholder="{{ __('app.flows.create.name') }}" name="flowName">
          </div> 
        </div>         
        <div class="col-md-10" >      
          <button  type="button" title = "Regresar" id="CreateSubmit" onclick="confirm('Todo el progreso se borrará si no ha sido guardado. ¿Desea salir del modo edición?  ')" class="btn btn-danger ml-auto">
            <i class="fas fa-arrow-left"></i>
          </button> 
          <span id='button-actions' class="float-right">      
            <button type="button"  title = "Guardar flujo"  class="btn btn-primary float-right" onclick="ajaxCall('{{ Auth::user()->username }}')">
              <i class="fas fa-save"> </i>
              Guardar flujo
            </button>
            <button type="button" title = "Agregar elemento final" class="btn btn-danger float-right" onclick="createStartEnd('draggable_final','Fin', 'bg-danger')">
              <i class="fas fa-plus-circle"> </i>
              Agregar final
            </button>
            <button type="button"  title = "Agregar paso" class="btn btn-info float-right" onclick="createStep({{$actions}})">
              <i class="fas fa-plus-circle"> </i>
              Agregar paso
            </button>
            <button type="button" title = "Agregar inicio"  class="btn btn-success float-right" onclick="createStartEnd('draggable_inicio', 'Inicio', 'bg-success')">
              <i class="fas fa-plus-circle"> </i>
              Agregar inicio
            </button> 
          </span>
        </div>
        <div class="col-md-10">&nbsp;</div>
        <div id = "steps" class="col-10" > </div> 
        
        
        </div>
    </div> 
    <!--Inicio del flujo de trabajo -->   
    <div class="row justify-content-center"> 
      <div class="col-1 staticPosition"></div>
      <div class="col-10" id= 'drag-container-wrapper'>
          <div id = 'drag-container-scrollable' style="width: 100%; height:600px; overflow:scroll"  >  
              <div class="" id= 'drag-container' style="width: 200%; height:200%"  >         
              </div>
          </div>
      </div> 
      <div class="col-1 staticPosition"></div>      
    </div> 
    <div id="drag-container-bottom" class="row staticPosition"> &nbsp;</div>   
</div>


