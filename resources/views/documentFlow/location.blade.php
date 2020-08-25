<div id = "locationModalS" class="modal fade">
  <div class="modal-dialog  modal-lg ">
      <div class="modal-content">
        <div class="modal-header">  
          
              <h2 id= "card-title" class="text-center"> {{ __('app.documentFlow.location.title') }} </h2>
          
          <button type="close" class="close" data-dismiss="modal"> 
              X
          </button>
      </div>
      <div class="modal-body" id = "modal-body-edit">
        @if ( !empty($step))
            <p> {{ __('app.documentFlow.location.actualStep') }}  <b>{{ $step->description }}</b>  </p> 
            <label for=""> {{ __('app.documentFlow.location.user') }} <b>{{ $step->description }}</b></label>  
            @else 
            <p>  {{ __('app.documentFlow.location.noStep') }} </p>
            <label for=""></label>  
          @endif   
          

         
          <table id='' class="table table-responsive table-striped" style="display:table">
            <thead class="head_table thead-dark ">   
                <th> {{ __('app.documentFlow.location.username') }} </th>    
                <th> {{ __('app.documentFlow.location.name') }}</th>      
                <th> {{ __('app.documentFlow.location.email') }}</th>        
            </thead>
            <tbody class="" >        
              @foreach ($users as $user)
              <tr>
                <td>{{$user->username}}</td>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
              </tr>    
              @endforeach      
            </tbody>
          </table>
          

      </div>
      <div class="modal-footer">     
          <span class=" text-right">
              <button data-toggle="modal" class=" float-right btn btn-danger" onclick="hideModal('locationModalS')" data-target="">
                  <i class=""></i>{{ __('app.documentFlow.location.close') }}
              </button>       
          </span>           
      </div>
      </div>
    </div>
  </div>
</div>
  
  
  