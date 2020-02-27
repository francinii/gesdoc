<div class="modal fade" id="edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">      
        <h2 class="text-center">Editar Rol</h2>
        <button type="close" class="close" data-dismiss="modal"> 
            X
        </button>
      </div>
      <div class="modal-body">
        <form action="{{url('/rols/'.$rol->id)}}" method="POST">
          {{csrf_field()}}
          {{method_field('PATCH')}}
           <div class="form-group">
            <input name="id" type="hidden">
             <label for="rol">Nombre del rol</label>
             <input type="text" class="form-control" id="description" placeholder="Nombre del rol" name="description" value="{{$rol->description}}">
           </div> 

           <button type="button" id="submit" class="btn btn-success">Actualizar</button>
         </form>
      </div>
      <div class="modal-footer">     
      </div>
    </div>
 </div>
</div>
