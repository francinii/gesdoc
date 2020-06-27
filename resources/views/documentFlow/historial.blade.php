
<div class="historial col-md-4" style="height: 80vh">  
    <div class="card" style="height:100%;">        
        <div class="card-header bg-danger">
            <div class="row">
                <div class="col-12">
                    <div>
                        <span> <b class="text-light">Documento: </b></span>
                        <span class="card-text text-light "> {{ $document->description }}</span>
                    </div>                                          
                    <div>
                        <span><b class="card-text text-light ">Código: </b></span>
                        <span class="card-text text-light">{{ $document->code }}</span>
                    </div>
                    <div>
                        <span><b class="card-text text-light">Propietario: </b></span>
                        <span class="card-text text-light">{{ $document->owner->name }}</span>
                    </div>                            
                </div>            
            </div>
        </div>
        <div  class="card-body" style = "overflow-y:scroll; padding:1%">
            @foreach ($versions as $verdoc)
                    <div>
                        @include('documentFlow.card')
                    </div>
            @endforeach
        </div>
    </div>   
</div>

<div class="historial col-md-8">
    <div id = "contentRight"></div>
  
</div>
