@extends('layouts.template')

@section('head')

    <script src="{{ asset('../resources/extensions/leaderline/leader-line.min.js') }}"></script>      
    <script src="{{ asset('../resources/extensions/dragdrop/plain-draggable.min.js') }}"></script>   
    <script src="{{ asset('../resources/js/sharedDocumentFunctions.js') }}" defer></script>   
    <script src="{{ asset('../resources/js/sharedfunctions.js') }}" defer></script> 
    <script src="{{ asset('../resources/js/documentFlows.js') }}" defer></script>
        <!-- Para el select con search -->
@stop

@section('title', 'Flujos') 

@section('header')
    @include('layouts.header') 
@stop
@section('content')
  
    <div class="container-fluid" id = "flow-wrapper" >          
        <div id = 'content' class="row justify-content-center">                
                <h2 class="text-center">{{ __('app.documentFlow.index.title') }}</h2>   
                     
            <div class="col-md-11 text-center">
                <div class="form-group">                                                                        
                    <select id='selectDoc' class="form-control selectpicker"  data-live-search="true"  >                
                    @foreach ($flows as $flow)      
                        <option  id = "{{$flow->id}}" value = "{{$flow->id}}">{{$flow->description}}</option>
                    @endforeach                                    
                    </select>                           
                  </div>                 
            </div>
            <div  class="col-md-12">&nbsp</div>
            <div class="col-11">
                @include('partials.alert')
                <div id="divTable" class="table-responsive" >
                @include('documentFlow.table')   
                </div>             
            </div>
        </div> 
    </div>
    @include('partials.alertModal') 
   
    <div id="locationModal">
       
    </div>
    
    


@stop