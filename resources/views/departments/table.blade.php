<table id='table' class="table table-responsive table-striped"  width="100%">
            <thead class="thead-dark">
                <tr>
                    <th  class="col-md-1 text-center" >Id</th>
                    <th  class="col-md-2 text-center" >Nombre</th>                    
                    <th  class="col-md-2  text-center"  >Unidad Academica</th>
                    <th  class="col-md-1 text-center"  >Editar usuario</th>                   
                    <th  class="col-md-1 text-center">Eliminar Usuario</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($departments as $department)
                <tr>
                    <td class="text-center">{{$department->id}}</td>
                    <td class="text-center">{{$department->description}}</td>
                    <td class="text-center">{{$department->academic_unit}}</td>                              
                    <td class="text-center">
                        <button onclick = "edit('{{$department->id}}','{{$department->description}}', '{{$department->academic_unit}}')"  class="btn btn-info"  data-toggle="modal" >
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>    
                    <td class="text-center">                        
                            <button type="button" onclick="confirmarDelete({{$department->id }}  ,'users','table','Desea eliminar el departamento {{$department->description}}?')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>                      
                    </td>                    
                </tr>
                @endforeach
            </tbody>
 </table>
