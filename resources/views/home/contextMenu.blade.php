<div class="dropdown-menu dropdown-menu-sm"  id="context-menu"  >
  <button id="createClassificationContext" data-toggle="modal" data-target="#create" class="btn btn-link dropdown-item" onclick="clearCreate()" ><i class="fas fa-plus-circle"></i> {{ __('app.home.contextMenu.createClassification') }}</button>
  <button id="createDocumentContext"  class="btn btn-link dropdown-item" onclick="createDoc(1)" ><i class="fas fa-file-medical"></i> {{ __('app.home.contextMenu.createDocument') }}</button>
  <button id="createSheetContext"  class="btn btn-link dropdown-item" onclick="createDoc(2)" ><i class="fas fa-file-medical"></i> {{ __('app.home.contextMenu.createSheet') }}</button>
  <button  id="editContext"  class="btn btn-link dropdown-item" onclick="edit()"><i class="fas fa-edit"></i> {{ __('app.home.contextMenu.editClassification') }}</button>
  <button id="deleteContext" class="btn btn-link dropdown-item" onclick="deletefile()"><i class="fas fa-trash-alt"></i> {{ __('app.home.contextMenu.delete') }}</button>
  <button id="shareContext"data-toggle="modal" class="btn btn-link dropdown-item" onclick="showshare()" ><i class="fas fa-share-alt-square"></i> {{ __('app.home.contextMenu.share') }}</button>
</div>
