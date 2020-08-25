<?php $countNotes = count($notes);?>
@if ($countNotes>0)
      @foreach ($notes as $note)
        <div class="card">
          <div class="card-header ">
            <span><b class="card-text card-title "></b></span>
                    
          </div>
          <div class="card-body">
              <div class="row">
                  <div class="col-12">      
                    <div>
                      <span><b class="card-text ">{{ __('app.documentFlow.notesContent.dateBegin') }}</b></span>
                      <span id = '' class="card-text">{{ $note->created_at }}</span> 
                    </div>
                    <div>            
                        <span><b class="card-text ">{{ __('app.documentFlow.notesContent.dateUpdate') }}</b></span>
                        <span id = '' class="card-text">{{ $note->updated_at }}</span>
                    </div>
                    <div>            
                      <span><b class="card-text ">{{ __('app.documentFlow.notesContent.content') }}</b></span>
                      <span class="card-text ">{{ $note->content }}</span>   
                  </div>           
                  </div>  
              </div>
          </div>
        </div>
        <div>&nbsp;</div>   
      @endforeach
@else
  <div class="card-header ">
      <span><b class="card-text card-title ">{{ __('app.documentFlow.notesContent.noInfo') }}</b></span>
  </div>
@endif

