<div id="tableTitle"></div>
<table id='table' class="table table-hover display nowrap"   >
            <thead class="thead-dark" >
                <tr>                   
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.type') }}</th>
                    <th style="width: 55%"  class="text-center" >{{ __('app.home.table.description') }}</th>  
                    <th style="width: 55%"  class="text-center" >{{ __('app.home.table.stade') }}</th> 
                    <th style="width: 20%"  class="text-center" >{{ __('app.home.table.create') }}</th> 
                    <th  style="width: 20%"  class="text-center" >{{ __('app.home.table.modified') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.id') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.flow_id') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.summary') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.code') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.languaje') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.others') }}</th>
                </tr>
            </thead>
            <tbody >                
                @foreach ($classifications as $classification)
                <tr onclick="openClassification({{$classification->id}})" data-toggle="tooltip" data-placement="top" title="{{ __('app.home.table.numberDocuments') }} {{$classification->documents->count()}}">                   
                    <td class="text-center " ><i class="fas fa-folder fa-2x" ></i><span style="display:none;">classification</span></td>
                    <td class="text-center ">{{$classification->description}}</td> 
                    <td class="text-center "></td>                              
                    <td class="text-center " >{{$classification->created_at}}</td>  
                    <td class="text-center ">{{$classification->updated_at}}</td>
                    <td style="display:none;" class="text-center ">{{$classification->id}}</td>
                    <td style="display:none;" class="text-center "></td>
                    <td style="display:none;" class="text-center "></td>
                    <td style="display:none;" class="text-center "></td>
                    <td style="display:none;" class="text-center "></td>
                    <td style="display:none;" class="text-center "></td>                  
                </tr>
                @endforeach
                @foreach ($documents as $document)
                <tr  onclick="openDocument({{$document->id}},{{$document->flow_id}})" data-toggle="tooltip" data-placement="top" title="{{$document->summary}}">

                     @if ($document->type=="docx" || $document->type=="doc")
                    <td class="text-center "><i class="far fa-file-word fa-2x "></i><span style="display:none;">{{$document->type}}</span></td>
                    @elseif($document->type=="xlsx" || $document->type=="xls")
                    <td class="text-center "><i class="far fa-file-excel fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                    @elseif($document->type=="ppt" || $document->type=="pptx" )
                    <td class="text-center"><i class="far fa-file-powerpoint fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                    @else
                    <td class="text-center"><i class="far fa-file fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                    @endif
                    <td class="text-center ">{{$document->description}}</td>  
                    <td class="text-center "><h5><span class="badge" style= 'background-color:{{$document->action->color}}; color:white'>{{$document->action->state}}</span></h5></td>                            
                    <td class="text-center ">{{$document->created_at}}</td>  
                    <td class="text-center ">{{$document->updated_at}}</td>
                    <td style="display:none;" class="text-center ">{{$document->id}}</td>
                    <td style="display:none;" class="text-center  ">{{$document->flow_id}}</td>
                    <td style="display:none;" class="text-center ">{{$document->summary}}</td>
                    <td style="display:none;" class="text-center ">{{$document->code}}</td>
                    <td style="display:none;" class="text-center ">{{$document->languaje}}</td>
                    <td style="display:none;" class="text-center ">{{$document->others}}</td>
                    
          
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
