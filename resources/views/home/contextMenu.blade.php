<div class="dropdown-menu dropdown-menu-sm"  id="context-menu"  >
  <button id="createClassificationContext" data-toggle="modal" data-target="#create" class="btn btn-link dropdown-item" onclick="clearCreate()" ><i class="fas fa-folder"></i> {{ __('app.home.contextMenu.createClassification') }}</button>
                      
          <li id="submenuContext" class="dropdown-submenu"><a class=" btn btn-link dropdown-item  dropdown-toggle" href="#"><i class="fas fa-plus-circle"></i> {{ __('app.home.contextMenu.create') }}</a>
              <ul class="dropdown-menu" >
              <button id="createDocumentContext"  class="btn btn-link dropdown-item" onclick="createDoc(1)" ><i class="far fa-file-word"></i> {{ __('app.home.contextMenu.createDocumentText') }}</button>
              <button id="createSheetContext"  class="btn btn-link dropdown-item" onclick="createDoc(2)" ><i class="far fa-file-excel"></i> {{ __('app.home.contextMenu.createSheet') }}</button>
              <button id="createSheetContext"  class="btn btn-link dropdown-item" onclick="createDoc(3)" ><i class="far fa-file-powerpoint"></i> {{ __('app.home.contextMenu.createPPT') }}</button>
              </ul>
          </li>   


  <button  id="editContext"  class="btn btn-link dropdown-item" onclick="edit()"><i class="fas fa-edit"></i> {{ __('app.home.contextMenu.editClassification') }}</button>
  <button  id="cloneContext"  class="btn btn-link dropdown-item" onclick="clone()"><i class="far fa-clone"></i> {{ __('app.home.contextMenu.copy') }}</button>
  <button id="removeContext" class="btn btn-link dropdown-item" onclick="deletefile(0)"><i class="fas fa-trash-alt"></i> {{ __('app.home.contextMenu.remove') }}</button>
  <button id="deleteContext" class="btn btn-link dropdown-item" onclick="deletefile(1)"><i class="fas fa-trash-alt"></i> {{ __('app.home.contextMenu.delete') }}</button>
  <button id="shareContext"data-toggle="modal" class="btn btn-link dropdown-item" onclick="showshare()" ><i class="fas fa-share-alt-square"></i> {{ __('app.home.contextMenu.share') }}</button>
  <button id="downloadContext"data-toggle="modal" class="btn btn-link dropdown-item" onclick="download()" ><i class="fas fa-download"></i> {{ __('app.home.contextMenu.download') }}</button>
  <button  class="btn btn-link dropdown-item" id="actionsContextMenu" disable><i class="fas fa-ban"></i> {{ __('app.home.contextMenu.noActions') }}</button>

  
</div>
