<table id='table' class="table table-responsive table-striped"  width="100%">
            <thead class="thead-dark">
                <tr>
                    <th  class="text-center" >{{ __('app.departments.table.id') }}</th>
                    <th  class="col-md-2 text-center" >{{ __('app.departments.table.description') }}</th>                    
                    <th  class="text-center"  >{{ __('app.departments.table.edit') }}</th>                   
                    <th  class="text-center">{{ __('app.departments.table.delete') }}</th>
                </tr>
            </thead>
            <tbody >
                @foreach ($departments as $department)
                <tr>
                    <td class="text-center">{{$department->id}}</td>
                    <td class="text-center">{{$department->description}}</td>                           
                    <td class="text-center">
                        <button onclick = "edit('{{$department->id}}','{{$department->description}}')"  class="btn btn-info"  data-toggle="modal" >
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>    
                    <td class="text-center">                        
                            <button type="button" onclick="confirmDelete({{$department->id }} ,'departments','table','Desea eliminar el departamento {{$department->description}}?')"  class=" btn btn-danger">
                                <i class="fas fa-trash-alt">
                                </i>
                            </button>                      
                    </td>                    
                </tr>
                @endforeach
            </tbody>
 </table>
