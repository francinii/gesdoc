<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
            <th style="width: 20%"  class="text-center">{{ __('app.record.table.user') }}</th>
            <th style="width: 20%"  class="text-center">{{ __('app.record.table.action') }}</th>            
            <th style="width: 20%"  class="text-center">{{ __('app.record.table.document') }}</th> 
            <th style="width: 10%"  class="text-center">{{ __('app.record.table.version') }}</th>  
            <th style="width: 20%"  class="text-center">{{ __('app.record.table.description') }}</th>                 
            <th style="width: 10%"  class="text-center">{{ __('app.record.table.Flow') }}</th>
            <th style="width: 10%"  class="text-center">{{ __('app.record.table.create') }}</th>
            <th style="width: 10%"  class="text-center">{{ __('app.record.table.modified') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($historial as $his)         
        <tr>
            <td class="text-center">{{$his->username}}</td>                                 
            <td class="text-center">{{$his->action}}</td>              
            <td class="text-center">{{$his->document_name}}</td>
            <td class="text-center">{{$his->version_id}}</td>  <!-- Cambiar el id por el numero de version-->  
            <td class="text-center">{{$his->description}}</td>
            <td class="text-center">{{$his->flow_name}}</td>
            <td class="text-center">{{$his->created_at}}</td>
            <td class="text-center">{{$his->updated_at}}</td>
            
        </tr>
        @endforeach
    </tbody>
 </table>
