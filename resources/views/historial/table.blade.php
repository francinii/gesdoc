<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width: 10%"  class="text-center">Usuario</th>
            <th style="width: 40%"  class="text-center">Acción</th>
            <th style="width: 10%"  class="text-center">Descripción</th>
            <th style="width: 20%"  class="text-center">Documento</th>                    
            <th style="width: 10%"  class="text-center">Versión</th>
            <th style="width: 10%"  class="text-center">Nombre del flujo</th>
            <th style="width: 10%"  class="text-center">Fecha de creación</th>
            <th style="width: 10%"  class="text-center">Fecha de modificación</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($historial as $his)         
        <tr>
            <td class="text-center">{{$his->id}}</td>
            <td class="text-center">{{$his->username}}</td>                                 
            <td class="text-center">{{$his->action}}</td>  
            <td class="text-center">{{$his->description}}</td>  
            <td class="text-center">{{$his->document_name}}</td>   
            <td class="text-center">{{$his->version_id}}</td>  <!-- Cambiar el id por el numero de version-->
            <td class="text-center">{{$his->created_at}}</td>
            <td class="text-center">{{$his->updated_at}}</td>
            
        </tr>
        @endforeach
    </tbody>
 </table>
