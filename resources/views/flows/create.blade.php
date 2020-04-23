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
              <text>pruebaa</text>
              </div> 
        </div> 
        <div class="col-md-10">
          <div class="float-right">
            <button type="button" class="btn btn-primary" onclick="createStep()">
              <i class="fas fa-plus-circle"> </i>
              Agregar paso
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
        
          <div id ="draggable_inicio" class="special_card card">
            <div class="card-step card-header bg-success">
                <label>Inicio </label>
                <button type="button" class="btn btn-warning" onclick="joinStep(draggable_inicio)">
                  <i class="fas fa-link"></i>
                </button>
            </div>        
        </div>
        <div id ="draggable_final" class="special_card card">
          <div class="card-step card-header bg-danger">
              <label>Fin</label>
              <button type="button" class="btn btn-warning" onclick="joinStep(draggable_final)">
                <i class="fas fa-link"></i>
              </button>
          </div>        
      </div>
        
      </div>
    </div>
    
</div>


