<table id='table' class="table table-hover"   >
            <thead class="thead-dark" >
                <tr>                   
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.type') }}</th>
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.description') }}</th>  
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.create') }}</th> 
                    <th  style="width: 10%"  class="text-center" >{{ __('app.home.table.modified') }}</th>
                    <th  style="display:none;" style=""  class="text-center" >{{ __('app.home.table.id') }}</th>
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
                    <tr>

                        @if ($document->type=="docx" || $document->type=="doc")
                        <td class="text-center "><i class="far fa-file-word fa-2x "></i><span style="display:none;">{{$document->type}}</span></td>
                        @elseif($document->type=="xlsx" || $document->type=="xls")
                        <td class="text-center "><i class="far fa-file-excel fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                        @elseif($document->type=="ppt")
                        <td class="text-center"><i class="far fa-file-powerpoint fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                        @else
                        <td class="text-center"><i class="far fa-file fa-2x"></i><span style="display:none;">{{$document->type}}</span></td>
                        @endif
                        <td class="text-center ">{{$document->description}}</td>                           
                        <td class="text-center ">{{$document->created_at}}</td>  
                        <td class="text-center ">{{$document->updated_at}}</td>
                        <td style="display:none;" class="text-center ">{{$document->id}}</td>
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
                    @endforeach
                @endforeach
            </tbody>
 </table>
