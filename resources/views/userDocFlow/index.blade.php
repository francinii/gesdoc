@extends('layouts.template')

@section('head')
    <script src="{{ asset('../resources/js/sharedFunctions.js') }}" defer></script>
    <script src="{{ asset('../resources/extensions/leaderline/leader-line.min.js') }}"></script>      
    <script src="{{ asset('../resources/extensions/dragdrop/plain-draggable.min.js') }}"></script>   

        <!-- Para el select con search -->
@stop

@section('title', 'Flujos') 

@section('header')
    @include('layouts.header') 
@stop
@section('content')
  
    <div class="container-fluid" id = "flow-wrapper" style="100%">          
        <div id = 'content' class="row justify-content-center">                
                <h2 class="text-center">Documentos compartidos en flujo</h2>        
            <div class="col-md-11 text-center">
                <div class="form-group">                                                                        
                    <select id='selectDoc2' class="form-control selectpicker"  data-live-search="true"  >                
                    @foreach ($flows as $flow)      
                        <option  id = "{{$flow->flow_id}}" value = "{{$flow->flow_id}}">{{$flow->description}}</option>
                    @endforeach                                    
                    </select>                           
                  </div>                 
            </div>
            <div  class="col-md-12">&nbsp</div>
            <div class="col-11">
                @include('partials.alert')
                @include('userDocFlow.table')                
            </div>
        </div> 
    </div>
    @include('partials.alertModal') 
    @include('documentFlow.create')
       
    <script src="{{ asset('../resources/js/documentFlows.js') }}" defer></script>

@stop