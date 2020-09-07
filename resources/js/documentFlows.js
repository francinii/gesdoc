var select = document.getElementById('selectDoc');
var allVersions;
var actualVersionEdit=2
if(select){
    select.addEventListener('change',
    function(){
        var selectedOption = this.options[select.selectedIndex];
    // alert(selectedOption.value + ': ' + selectedOption.text);
        var idFlow = selectedOption.value;
        var me = $(this);
        if (me.data("requestRunning"))
        return;

        $.ajax({
            url: "documentFlow/{" + idFlow + "}",
            method: "GET",
            headers: {
            
            },
            data: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            _token: $("input[name=_token]").val(),
            idFlow: idFlow,
                
            },
            beforeSend: function (xhr) {
                me.data("requestRunning", true); 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                me.data("requestRunning", false); 
                $("#cargandoDiv").css('display', 'none');
                $("#divTable").html(result);
                $("#table").DataTable().destroy();
                
                createDataTable("table");            
            
            },

            error: function(request, status, error) {
                me.data("requestRunning", false); 
                alert(request.responseText);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                $("#cargandoDiv").css('display', 'none')
            }
        });
    
    });
}



//Version para usuarios

var select2 = document.getElementById('selectDoc2');
if(select2){
    select2.addEventListener('change',
    function(){
        var selectedOption = this.options[select2.selectedIndex];
    // alert(selectedOption.value + ': ' + selectedOption.text);
        var idFlow = selectedOption.value;

        var me = $(this);
        if (me.data("requestRunning"))
        return;
        
        $.ajax({
            url: "userDocFlow/{" + idFlow + "}",
            method: "GET",
            headers: {
            
            },
            data: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            _token: $("input[name=_token]").val(),
            idFlow: idFlow,
                
            },
            beforeSend: function (xhr) { 
                me.data("requestRunning", true); 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                me.data("requestRunning", false); 
                $("#cargandoDiv").css('display', 'none');
                $("#divTable").html(result);
                $("#table").DataTable().destroy();
                
                createDataTable("table");            
            
            },

            error: function(request, status, error) {
                me.data("requestRunning", false); 
                alert(request.responseText);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                $("#cargandoDiv").css('display', 'none')
            }
        });
    
    });
}

function isCheckNote(event){
    // $('#checkboxNota').change(function() {
        if($(event).is(":checked")) {
            $('#textNote').css("display", 'block');
        }else {
            $('#textNote').css("display", 'none');
        }
    // $('#textbox1').val($(this).is(':checked'));        
   // });
}
   





/** 
 *  @param {int} idDoc - document id
 *  @param {int} screen -  1-vista previa 2-notas
 * 
 */
function preview(idDoc,screen){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "documentFlow/preview/{" + idDoc + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idDoc: idDoc,
           version:"last",
           mode:2,
           edit:2, // 1 can edit 2 prewiew  
           screen: screen, 
            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none');
            $("#content").html(result);
      },

        error: function(request, status, error) {
            me.data("requestRunning", false);
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}

/** 
 *  @param {int} code - array of users with ther actions, 
 *  1-vista previa 2-notas 3-descargas 4-historial de acciones
 *  @param {string} version - array of users with ther actions.
 *  @param {string} document - array of users with ther actions.
 *  
 * @return {Array} usersAux - return an array of users with their correspondent actions * 
 */
function openPanel(code, version,document,versionNum){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "documentFlow/historial/panel/{" + code + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           code: code,
           version:version,
           versionNum:versionNum,
           document: document,
            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none');
            $("#contentRight").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
            me.data("requestRunning", false);
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });


}



function nextVersion(opc, version_num, idDoc){
    var me = $(this);
    if (me.data("requestRunning"))
        return;

    (opc==1)? version_num++: version_num--;

   

    var index=allVersions.findIndex(x => x == version_num);
    if(index<0)
     return;
    $.ajax({
        url: "documentFlow/nextVersion/{" + idDoc + "}",
        method: "GET",
        headers: {           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           opc:opc,
           version_num:version_num,
           idDoc:idDoc,
           mode:2,
           edit:2, // 1 can edit 2 prewiew            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none');
            $("#panel-preview").html(result);      
        },

        error: function(request, status, error) {   
            me.data("requestRunning", false);       
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}


function modalNotes(version, versionNum){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "documentFlow/notesModal/{" + version + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           version:version,
           versionNum:versionNum,            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true);  
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);  
            $("#cargandoDiv").css('display', 'none');
            $("#modal-body-notes").html(result);
            $('#modal-notes').modal('show');                 
        },
        error: function(request, status, error) { 
            me.data("requestRunning", false);           
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
}


function modalEdit(version, versionNum){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "documentFlow/modalEditVersion/{" + version + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           version:version,
           versionNum:versionNum,            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none');
            $("#modal-edit-version").html(result);
            $('#modal-edit-version').modal('show');                 
        },
        error: function(request, status, error) {  
            me.data("requestRunning", false);        
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
        
}


function hideModal(mod){
    $('#'+mod).modal('hide'); 
}

function flowProcess(version){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    var action = $("select[name=action_create] option:selected").val();
    var text_notas = $('#text_notas').val();
    var isCheck = $('#checkboxNota').is(":checked");
    $.ajax({
        url: "documentFlow/flowProcess/{" + version + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           version:version,   
           action:action,
           text_notas: text_notas,
           isCheck: isCheck,
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true); 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false); 
            $("#cargandoDiv").css('display', 'none');
            alerts('alerts', 'alert-content',"El documento ha sido enviado correctamente.", "alert-success");
            $('#modal-edit-version').modal('hide');
            location.reload();
          //  location.href="" ;                
        },
        error: function(request, status, error) {    
            me.data("requestRunning", false);       
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}



function locationModal(idDoc){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "documentFlow/location/{" + idDoc + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idDoc: idDoc,
            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true); 
            $("#cargandoDiv").css('display', 'block');
        },
        success: function(result) {
            me.data("requestRunning", false); 
            $("#cargandoDiv").css('display', 'none');
            $("#locationModal").html(result);  
            $("#locationModalS").modal('show');             
        },
        error: function(request, status, error) {  
            me.data("requestRunning", false);         
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
}

function editionMode(document_id, versionNum){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    (actualVersionEdit==1)?actualVersionEdit++:actualVersionEdit--;
    $.ajax({
        url: "documentFlow/editionMode/{" + versionNum + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           document_id:document_id,
           versionNum:versionNum,
           mode:2,
           edit:actualVersionEdit,                
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none');
            $("#panel-actual").html(result);   
        },
        error: function(request, status, error) { 
            (actualVersionEdit==1)?actualVersionEdit++:actualVersionEdit--;
            me.data("requestRunning", false);        
            alert(request.responseText);            
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}

/**
 * Show the version historial
 *  
 */
function historial(idDoc){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        //url: "historial/{" + idDoc + "}",
        url: "documentFlow/historial/{" + idDoc + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idDoc: idDoc,
            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true); 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false); 
            $("#cargandoDiv").css('display', 'none');
            $("#content").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
            me.data("requestRunning", false); 
            alert(error);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
}
/**
 * 
 */
function upload(){
    $("#file").change(function(e){
        var file1 = $('#file')[0]
        var archivo = file1.files[0]; 
        var fullname=archivo.name.split(".");
        var type=fullname.pop();
        var name='';
        fullname.forEach(element => {
            name+=element;
        });
        $('#nameU').val(name)
    });
    $('#nameU').val('');
    $("#nameU").removeClass("is-invalid");
    $('#uploadDocument').modal('show');
}
/**
 * put the name of file in upload file 
 */

/**
 *  This function validates the inputs of the create form in the browser
 *  
 */
function validaUploadDoc() {
    var validado = true;
    if ($("#nameU").val() == "") {
        $("#nameU").addClass("is-invalid");
        validado = false;
    } else {
        $("#nameU").removeClass("is-invalid");
    }
    var _validFileExtensions = ["jpg", "jpeg", "bmp", "gif", "png",'xls','xlsx','doc', 'docx','ppt', 'pptx','txt','pdf']; 
    var file1 = $('#file')[0]
    var archivo = file1.files[0];
    var index;
    if(typeof archivo !== 'undefined'){
    var fullname=archivo.name.split(".");
    var type=fullname.pop();
    index=_validFileExtensions.findIndex(x => x == type);
    }else{
        index=-1;
    }

    if(index==-1){
        $("#file").addClass("is-invalid");
        $("#file_message").html("tipo de archivo invalido");
        validado = false;
    }else{
        $("#file").removeClass("is-invalid");
        $("#file_message").html("");
    }
    return validado;
}

/**
 * Send an ajax request in order to upload a file to the server 
 * 
 * @param {int} document_id  id of document
 * @param {int} version  id of version
 * 
 */
function ajaxUploadDoc(document_id,version,versionNum) {
    var me = $(this);

    if (me.data("requestRunning"))
        return;
    if (validaUploadDoc()) {
        var description = $("#nameU").val();
        var file1 = $('#file')[0]
        var archivo = file1.files[0]; 
        
        var fullname=archivo.name.split(".");
        var docType=fullname.pop();
 
    
           
        var formData = new FormData();
        formData.append('X-CSRF-TOKEN"',$('meta[name="csrf-token"]').attr("content"));
        formData.append('_token',$("input[name=_token]").val());
        formData.append('description',description);
        formData.append('docType',docType);
        formData.append('document_id',document_id);
        formData.append('version',version);
        formData.append('versionNum',versionNum);
        formData.append('archivo',archivo);

        $.ajax({
            url: "documentFlow/updateDocument/{" + document_id + "}",
            method: "POST",
            processData: false,
            contentType: false,
            data: formData,
            
            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
                me.data("requestRunning", false);  
            },
            success: function (result) {
                $("#cargandoDiv").css('display', 'none');
                me.data("requestRunning", false);  
                $("#uploadDocument").modal('hide'); 
                $("#table").DataTable().destroy();
                $("#divTable").html(result);
                createDataTableHome("table");                          
                alerts('alerts', 'alert-content',"El documento " +  description +
                "ha sido agregado satisfactoriamente, espere mientras se redirecciona al nuevo documento", "alert-success");
                             
            },
            error: function (request, status, error) {
                $("#cargandoDiv").css('display', 'none')
                me.data("requestRunning", false);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
               
                
            },
        });
    }
}