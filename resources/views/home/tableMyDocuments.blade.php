<div id="tableTitle"></div>
<table id='table' class="table table-responsive table-striped"  width="100%" >

            <thead class="thead-dark" >
                <tr>
                   
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.type') }}</th>
                    <th style="width: 55%"  class="text-center" >{{ __('app.home.table.description') }}</th>  
                    <th style="width: 15%"  class="text-center" >{{ __('app.home.table.create') }}</th> 
                    <th  style="width: 15%"  class="text-center" >{{ __('app.home.table.modified') }}</th>
                    <th  style="display:none;" style="width: 5%"  class="text-center" >{{ __('app.home.table.id') }}</th>
                
                </tr>
            </thead>
            <tbody >
                
                @foreach ($classifications as $classification)
                <tr onclick="openClassification({{$classification->id}})">
                   
                    <td class="text-center" ><i class="fas fa-folder fa-2x" ></i><span style="display:none;">classification</span></td>
                    <td class="text-center">{{$classification->description}}</td>                           
                    <td class="text-center">{{$classification->created_at}}</td>  
                    <td class="text-center">{{$classification->updated_at}}</td>
                    <td style="display:none;" class="text-center">{{$classification->id}}</td>
          
                </tr>
                @endforeach
                @foreach ($mainClassification->documents as $document)
                <tr>

                     @if ($document->type=="doc")
                    <td class="text-center"><i class="far fa-file-word fa-2x "></i><span style="display:none;">{{$document->type}}</span></td>
                    @elseif($document->type=="xls")
                    <td class="text-center"><i class="far fa-file-excel fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                    @elseif($document->type=="ppt")
                    <td class="text-center"><i class="far fa-file-powerpoint fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                    @else
                    <td class="text-center"><i class="far fa-file fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                    @endif
                    <td class="text-center">{{$document->description}}</td>                           
                    <td class="text-center">{{$document->created_at}}</td>  
                    <td class="text-center">{{$document->updated_at}}</td>
                    <td style="display:none;" class="text-center">{{$document->id}}</td>
          
                </tr>
                @endforeach
            </tbody>
 </table>
 <script>
    $( document ).ready(function() {
        var js_data = '<?php echo json_encode($mainClassification); ?>';        
         currentClassification=JSON.parse(js_data );
         var js_data = '<?php echo json_encode($myActions); ?>';        
         var myActions=JSON.parse(js_data );
         definePermmisision(myActions);
         drawRoute();
    });
</script>
