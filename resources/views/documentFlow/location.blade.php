<div id = "locationModalS" class="modal fade">
  <div class="modal-dialog  modal-lg ">
      <div class="modal-content">
        <div class="modal-header">  
          
              <h2 id= "card-title" class="text-center">Ubicación del documento</h2>
          
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
      </div>
      <div class="modal-body" id = "modal-body-edit">
        @if ( !empty($step))
            <p> El documento se encuentra actualmente en el paso:  <b>{{ $step->description }}</b>  </p> 
            <label for="">Usuarios asociados al paso: <b>{{ $step->description }}</b></label>  
            @else 
            <p> El documento no está asociado a un paso en el flujo.</p>
            <label for="">Usuarios asociados al paso</label>  
          @endif   
          

         
          <table id='' class="table table-responsive table-striped" style="display:table">
            <thead class="head_table thead-dark ">   
                <th>Usuario</th>    
                <th>Nombre</th>      
                <th>Correo</th>        
            </thead>
            <tbody class="" >        
              @foreach ($users as $user)
              <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
              </tr>    
              @endforeach      
            </tbody>
          </table>
          

      </div>
      <div class="modal-footer">     
          <span class=" text-right">
              <button data-toggle="modal" class=" float-right btn btn-danger" onclick="hideModal('locationModalS')" data-target="">
                  <i class=""></i>Cerrar
              </button>       
          </span>           
      </div>
      </div>
    </div>
  </div>
</div>
  
  
  