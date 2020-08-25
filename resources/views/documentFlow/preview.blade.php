<div class="col-12">
    @include('partials.alert')
</div>
<div id = "panel-preview" class="col-6" style="height: 80vh">
    @include('documentFlow.oldVersion') 
</div>
<div  id = "panel-actual" class="col-6 panel-actual" style="height: 80vh">
    @include('documentFlow.actualVersion') 
</div>
<div class="modal fade" id="modal-notes">   
    @include('documentFlow.notesModal')    
</div>
  
<div class="modal fade" id="modal-edit-version"> 
</div>    
<script>
    $( document ).ready(function() {
        var js_data = '<?php echo json_encode($allVersions); ?>';        
        allVersions=JSON.parse(js_data );
    });
</script>
