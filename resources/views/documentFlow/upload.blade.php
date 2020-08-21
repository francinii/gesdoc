<div id = "uploadDocument" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content">
        <div class="modal-header">      
            <h5 class="modal-title">Subir Documento</h5>
            <button type="close" class="close" data-dismiss="modal">  X </button>
        </div>
        <div class="modal-body">   
          <form action="" method="POST" enctype="multipart/form-data">
          {{csrf_field()}}       

            <div id= "docUpload" class="form-group">
              <label for="uploadLabel">Subir documento</label>   
              <input type="file" id="file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" /> <label for="file" class="btn-3 btn-info btn-block"> <i class="fa fa-upload"></i> Importar documento</label>
              <span class="text-danger" role="alert">
                  <strong id="file_message"></strong>
              </span> 
            </div>

            <div class="form-group">
              <label for="nameU">{{ __('app.documents.general.name') }}</label>
              <input type="text" class="form-control" id="nameU" placeholder="{{ __('app.documents.general.name') }}" name="nameU" disabled>

            </div>
        </div>
        <div class="modal-footer">
        <button  type="button" id="CreateSubmit" onclick="ajaxUploadDoc({{$actualVersion->document_id }},{{$actualVersion->id }},{{$actualVersion->version }})" class="btn btn-success">Subir</button>
         </div>
        </div>
    </div>
  </div>
  
  
    
  
  
  
  