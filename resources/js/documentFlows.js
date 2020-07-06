

var select = document.getElementById('selectDoc');
if(select){
select.addEventListener('change',
  function(){
    var selectedOption = this.options[select.selectedIndex];
   // alert(selectedOption.value + ': ' + selectedOption.text);
    var idFlow = selectedOption.value;

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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#table").html(result);
            $("#table").DataTable().destroy();
            
            createDataTable("table");            
           
        },

        error: function(request, status, error) {
           
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
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                $("#cargandoDiv").css('display', 'none');
                $("#table").html(result);
                $("#table").DataTable().destroy();
                
                createDataTable("table");            
            
            },

            error: function(request, status, error) {
            
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
   


function historial(idDoc){

    $.ajax({
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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#content").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}

function preview(idDoc){

    $.ajax({
        url: "documentFlow/preview/{" + idDoc + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idDoc: idDoc,
            
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#content").html(result);
      },

        error: function(request, status, error) {
          
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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#contentRight").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });


}



function nextVersion(opc, version_num, idDoc){
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
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#panel-preview").html(result);      
        },

        error: function(request, status, error) {          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}


function modalNotes(version, versionNum){
     
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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#modal-body-notes").html(result);
            $('#modal-notes').modal('show');                 
        },
        error: function(request, status, error) {          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
}


function modalEdit(version, versionNum){

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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#modal-edit-version").html(result);
            $('#modal-edit-version').modal('show');                 
        },
        error: function(request, status, error) {          
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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
           // $("#modal-edit-version").html(result);
            $('#modal-edit-version').modal('hide');                 
        },
        error: function(request, status, error) {          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}



function locationModal(idDoc){
    
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
            $("#cargandoDiv").css('display', 'block');
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#locationModal").html(result);  
            $("#locationModalS").modal('show');             
        },
        error: function(request, status, error) {          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
}