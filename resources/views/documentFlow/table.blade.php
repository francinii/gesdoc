<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width:5%"  class="text-center">{{ __('app.flows.table.id') }}</th>
            <th style="width: 20%"  class="text-center">Descripcion</th>  
            <th style="width: 20%"  class="text-center">Código</th>                    
            <th style="width: 15%"  class="text-center">Estado</th>
            <th style="width: 15%"  class="text-center">Departamento</th>
            <th style="width: 15%"  class="text-center">Vista Previa</th>
            <th style="width: 10%"  class="text-center">Historial</th>
        </tr>
    </thead>
    <tbody>        
        @foreach ($documents as $document)       
        <tr>
            <td class="text-center">{{$document->id}}</td>
            <td class="text-center">{{$document->description}}</td>
            <td class="text-center">{{$document->code}}</td>         
            <td class="text-center"><h5><span class="badge" style= 'background-color:{{$document->action->color}}; color:white'>{{$document->action->state}}</span></h5></td>                                                 
            <td class="text-center"></td>
            <td class="text-center">
                    <button onclick = "preview({{$document->id}})"   class="btn btn-info"  data-toggle="modal" >
                        <i class="fas fa-eye" ></i>
                    </button>
            </td>
            <td class="text-center">
                <button onclick = "historial({{$document->id}})"  class="btn btn-warning"  data-toggle="modal" >
                    <i class="fas fa-file"></i>
                </button>
            </td>      
        </tr>
        @endforeach
    </tbody>
 </table>
