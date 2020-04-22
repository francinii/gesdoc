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
                @foreach ($classifications as $classification)
                <tr>
                     <td class="text-center">{{$classification->id}}</td>
                    <td class="text-center"><i class="fas fa-folder fa-2x"></i></td>
                    <td class="text-center">{{$classification->description}}</td>                           
                    <td class="text-center">{{$classification->created_at}}</td>  
                    <td class="text-center">{{$classification->updated_at}}</td>
          
                </tr>
                @endforeach
            </tbody>
 </table>
