<div class="container-fluid " id = "create-wrapper"  style="display:none">    
    <div class="row  justify-content-center">         
        <div  class="col-md-10">
          <div class="float-lg-left"> 
            <button  type="button" id="CreateSubmit" onclick="openTable()" class="btn btn-success">
              <i class="fas fa-arrow-left"></i>
            </button>     
          </div>          
        </div>
        <div  class="col-md-10 container">
          <div class="form-group row">
              <label class="control-label col-2" for="flowName"> {{ __('app.flows.create.name') }} </label>
              <input type="text" class="form-control col-10" id="flowName" placeholder="{{ __('app.flows.create.name') }}" name="flowName">
             
              </div> 
        </div> 
        <div class="col-md-10">
          <div class="float-right">
            <button type="button" class="btn btn-primary" onclick="createStep()">
              <i class="fas fa-plus-circle"> </i>
              Agregar paso
            </button>
            <button type="button" class="btn btn-success" onclick="createStartEnd('draggable_inicio', 'Inicio', 'bg-success')">
              <i class="fas fa-plus-circle"> </i>
              Agregar inicio
            </button>
            <button type="button" class="btn btn-danger" onclick="createStartEnd('draggable_final','Fin', 'bg-danger')">
              <i class="fas fa-plus-circle"> </i>
              Agregar final
            </button>
          </div>
        </div>
        <div class="col-md-10">&nbsp;</div>
        <div id = "steps" class="col-10" >              
        </div>              
    </div> 

    <!--Inicio del flujo de trabajo -->
   
    <div class="row">  
      <div class="col-12" id= 'drag-container'  >       
        
        
      </div>
    </div>
    
</div>


