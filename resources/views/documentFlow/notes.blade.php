  <div class="card " style="height: 80vh">
      <div class="card-header bg-danger ">
        <h5 class="card-title text-light">Notas de la versión: {{$versionNum}}</h5>    
      </div>
      <div class="card-body" style = "height:100%;  overflow-y:scroll; padding:2%">      
           @include('documentFlow.notesContent') 
      </div>
  </div>


