<table id='table' class="table table-striped">
    <thead class="thead-dark">
        <tr class="">
           <!-- <th style="width:10%"  class="text-center">{{ __('app.flows.table.id') }}</th> -->
            <th style="width: 10%"  class="text-center">{{ __('app.userDocFlow.table.code') }} </th> 
            <th style="width: 50%"  class="text-center">{{ __('app.userDocFlow.table.document') }} </th>  
            <th style="width:10%"  class="text-center">{{ __('app.userDocFlow.table.preview') }} </th>
            <th style="width: 10%"  class="text-center">{{ __('app.userDocFlow.table.versions') }} </th>
        </tr>
    </thead>
    <tbody>        
        @foreach ($documents as $document)       
        <tr>
           <!-- <td class="text-center">{{$document->id}}</td> -->
           <td class="text-center">{{$document->code}}</td>  
            <td class="text-center">{{$document->description}}</td>     
            <td class="text-center">
                    <button onclick = "preview({{$document->id}},2)"   class="btn btn-info"  data-toggle="modal" >
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
 <script>
    $( document ).ready(function() {
         var js_data = '<?php echo json_encode($notifications); ?>';        
         var notifications=JSON.parse(js_data );
         updateNotifications(notifications)
    });
</script>