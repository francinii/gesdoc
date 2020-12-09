<table id='table' class="table table-hover"   >
            <thead class="thead-dark" >
                <tr>                   
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.type') }}</th>
                    <th  style="width: 10%" style=""  class="text-center" >{{ __('app.home.table.version') }}</th>
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.description') }}</th>  
                    <th style="width: 10%"  class="text-center" >Estado</th>
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.create') }}</th> 
                    <th  style="width: 10%"  class="text-center" >{{ __('app.home.table.modified') }}</th>                   
                    <th  style="width: 10%"   class="text-center" >{{ __('app.home.table.classification') }}</th>
                    <th  style="width: 10%" class="text-center" >{{ __('app.home.table.flow_id') }}</th>                    
                    <th  style="width: 10%"   class="text-center" >{{ __('app.home.table.summary') }}</th>
                    <th  style="width: 10%"   class="text-center" >{{ __('app.home.table.code') }}</th>
                    <th  style="width: 10%" class="text-center" >{{ __('app.home.table.languaje') }}</th>
                    <th  style="width: 10%"   class="text-center" >{{ __('app.home.table.others') }}</th>
                    
                </tr>
            </thead>
            <tbody >
                @foreach ($Classifications as $Classification)
                    @foreach ($Classification->documents as $document)
                         @if ($Classification->type==1 || $Classification->type==1 || in_array($document->id, $idDocuments) )
                            <tr onclick="openDocument({{$document->id}},{{$document->flow_id}})" data-toggle="tooltip" data-placement="top" title="{{$document->summary}}">
                                @if ($document->type=="docx" || $document->type=="doc")
                                <td class="text-center "><i class="far fa-file-word fa-2x "></i><span style="display:none;">{{$document->type}}</span></td>
                                @elseif($document->type=="xlsx" || $document->type=="xls")
                                <td class="text-center "><i class="far fa-file-excel fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                                @elseif($document->type=="ppt")
                                <td class="text-center"><i class="far fa-file-powerpoint fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                                @else
                                <td class="text-center"><i class="far fa-file fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                                @endif
                                <td style="text-center" class="text-center ">{{$document->id}}.{{$document->currentVersion()}}</td>
                                <td class="text-center ">{{$document->description}}</td>   
                                <td class="text-center "><h5><span class="badge" style= 'background-color:{{$document->action->color}}; color:white'>{{$document->action->state}}</span></h5></td>                            
                                <td class="text-center ">{{$document->created_at}}</td>  
                                <td class="text-center ">{{$document->updated_at}}</td>                                
                                <td  class="text-center ">{{$Classification->description}}</td>  
                                @if($document->flow!=null)
                                    <td  class="text-center  ">{{$document->flow->description}}</td>
                                @else
                                    <td class="text-center  ">{{$document->flow}}</td>
                                @endif
                                <td class="text-center ">{{$document->summary}}</td>
                                <td  class="text-center ">{{$document->code}}</td>
                                <td  class="text-center ">{{$document->languaje}}</td>
                                <td  class="text-center ">{{$document->others}}</td>                                       
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
 </table>
 <script>
    $( document ).ready(function() {
         var js_data = '<?php echo json_encode($notifications); ?>';        
         var notifications=JSON.parse(js_data );
         updateNotifications(notifications);

         js_data = '<?php echo json_encode($allClassification); ?>';        
         allClassification=JSON.parse(js_data );
    });
</script>