<table id='table' class="table table-responsive table-striped"  width="100%">
            <thead class="thead-dark" >
                <tr>
                   <th  style="width: 10%"  class="text-center" >{{ __('app.home.table.id') }}</th>
                    <th style="width: 10%"  class="text-center" >{{ __('app.home.table.type') }}</th>
                    <th style="width: 50%"  class="text-center" >{{ __('app.home.table.description') }}</th>  
                    <th style="width: 15%"  class="text-center" >{{ __('app.home.table.create') }}</th> 
                    <th  tyle="width: 15%"  class="text-center" >{{ __('app.home.table.modified') }}</th>
                
                </tr>
            </thead>
            <tbody >
                
                @foreach ($classification->classifications as $classifications)
                <tr>
                     <td class="text-center">{{$classifications->id}}</td>
                    <td class="text-center"><i class="fas fa-folder fa-2x" value="folder"></i></td>
                    <td class="text-center">{{$classifications->description}}</td>                           
                    <td class="text-center">{{$classifications->created_at}}</td>  
                    <td class="text-center">{{$classifications->updated_at}}</td>
          
                </tr>
                @endforeach
                @foreach ($classification->documents as $document)
                <tr>
                     <td class="text-center">{{$document->id}}</td>
                     @if ($document->type="doc")
                    <td class="text-center"><i class="fas fa-file-word fa-2x"><span style="display:none;">{{$document->type}}</span></i></td>
                    @elseif($document->type="xls")
                    <td class="text-center"><i class="fas fa-file-word fa-2x"><span style="display:none;">{{$document->type}}</span></i></td>
                    @elseif($document->type="ppt")
                    <td class="text-center"><i class="fas fa-file-powerpoint fa-2x"><span style="display:none;">{{$document->type}}</span></i></td>
                    @else
                    <td class="text-center"><i class="fas fa-file fa-2x"><span style="display:none;">{{$document->type}}</span></i></td>
                    @endif
                    <td class="text-center">{{$document->description}}</td>                           
                    <td class="text-center">{{$document->created_at}}</td>  
                    <td class="text-center">{{$document->updated_at}}</td>
          
                </tr>
                @endforeach
            </tbody>
 </table>
