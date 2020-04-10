<div class="modal fade" id="list">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">      
          <h2 class="text-center" id='list_role'></h2>
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
        </div>
        <div class="modal-body">            
          <label for="select_document">Departamento</label>
          <div class="form-group">
            <select id='select_document' class="form-control" onchange="changeDepartment({{$users}})" data-live-search="true">                 
               @foreach ($departments as $department)
                <option id = "{{$department->id}}">{{$department->description}}</option>
              @endforeach  
              <option selected>Elegir</option>      
            </select>                           
          </div>           
          <table id='tablelist' class="table table-responsive table-striped" style="display:table">
            <thead class="head_table thead-dark ">   
                <th>Usuario</th>    
                <th>Nombre</th>      
                <th>Correo</th>      
                <th>Agregar</th>             
            </thead>
            <tbody class="body_table" >              
            </tbody>
          </table>
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