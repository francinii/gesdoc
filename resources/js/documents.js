/** 
 * Clean the inputs
 * 
 */
function clearDescription() {
    $("input[name=descriptionCreate]").val("");
}


/**
 *  This function validates the inputs of the create form in the browser
 *  
 */
function validaCreate() {
    var validado = true;
    if ($("input[name=descriptionCreate]").val() == "") {
        $("input[name=descriptionCreate]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=descriptionCreate]").removeClass("is-invalid");
    }
    if ($("#summary").val() == "") {
        $("#summary").addClass("is-invalid");
        validado = false;
    } else {
        $("#summary").removeClass("is-invalid");
    }
    if ($("#docType").val() == "") {
        $("#docType").addClass("is-invalid");
        validado = false;
    } else {
        $("#docType").removeClass("is-invalid");
    }
    if ($("#code").val() == "") {
        $("#code").addClass("is-invalid");
        validado = false;
    } else {
        $("#code").removeClass("is-invalid");
    }

    return validado;
}

/**
 * Send an ajax request in order to add a flow 
 * 
 * @param {integer} user - user id
 * @param {integer} mode - define if is a document for edit or for storage.  0-edit 1-storage
 * 
 */
function ajaxCreateDoc(user, mode) {
    if (validaCreate()) {
        var flow = $("#flowCreate option:selected").val();
        var description = $("input[id=descriptionCreate]").val();
        var summary = $("#summary").val();
        var type = $("#docType").val();
        var code  = $("#code").val();        
        var version = 1;
        var route = "";
        var size = "";
        var content = "";
        if(type == 1)
            docType = 'docx';
        else if(type == 2)
            docType = 'xlsx';                  
           
        $.ajax({
            url: "documents",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                description: description,
                flow_id: flow,
                user_id: user,
                state_id : 1,
                summary: summary,
                docType:docType,
                code:code,
                route:route,
                content:content,
                version:version,
                size:size, 
                mode:mode,                 
            },

            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#cargandoDiv").css('display', 'none');
                $("#createDocument").modal('hide'); 
                $("#table").DataTable().destroy();
                $("#divTable").html(result);
                createDataTable("table");                          
                alerts('alerts', 'alert-content',"El documento " +  description +
                "ha sido agregado satisfactoriamente, espere mientras se redirecciona al nuevo documento", "alert-success");
                var type = $("#docType").val();            
                if(type == 1){
                    window.location="documents/textEditor";
                }else {
                    window.location="documents/spreadSheetEditor";
                }
                 me.data("requestRunning", false);                

            },
            error: function (request, status, error) {
                $("#cargandoDiv").css('display', 'none')
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                me.data("requestRunning", false);
                
            },
        });
    }
}


/**
 * Send an ajax request in order to upload a file to the server 
 * 
 * @param {integer} user - user id
 * @param {integer} mode - define if is a document for edit or for storage.  0-edit 1-storage
 * 
 */
function ajaxUploadDoc(user, mode) {

    
        var flow = $("#flowCreate option:selected").val();
        var description = $("input[id=descriptionCreate]").val();
        var summary = $("#summaryU").val();
        //var type = $("#docType").val();
        var code  = $("#codeU").val();        
        var version = 1;
        var docType = '';
        var route = "";
        var content = "";
        var file1 = document.getElementById("file");
        var archivo1 = file1.files[0];             
        var formData = new FormData();
        formData.append('archivo1',archivo1);
        $.ajax({
            url: "documents",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                description: description,
                flow_id: flow,
                user_id: user,
                state_id : 1,
                summary: summary,
                docType:docType,
                code:code,
                route:route,
                content:content,
                version:version,
                mode:mode,  
                files: formData,                
            },

            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#cargandoDiv").css('display', 'none');
                $("#createDocument").modal('hide'); 
                $("#table").DataTable().destroy();
                $("#divTable").html(result);
                createDataTable("table");                          
                alerts('alerts', 'alert-content',"El documento " +  description +
                "ha sido agregado satisfactoriamente, espere mientras se redirecciona al nuevo documento", "alert-success");
                var type = $("#docType").val();            
                if(type == 1){
                    window.location="documents/textEditor";
                }else {
                    window.location="documents/spreadSheetEditor";
                }
                 me.data("requestRunning", false);                

            },
            error: function (request, status, error) {
                $("#cargandoDiv").css('display', 'none')
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                me.data("requestRunning", false);
                
            },
        });
    
  /*  if (1) {
        var flow = $("#flowCreate option:selected").val();
        var description = $("input[id=descriptionCreate]").val();
        var summary = $("#summary").val();
        var type = $("#docType").val();
        var code  = $("#code").val();        
        var version = 1;
        var route = "";
        var content = "";
        if(type == 1)
            docType = 'docx';
        else if(type == 2)
            docType = 'xlsx';   
            
            
       // var file1 = document.getElementById("file");
         //   var archivo1 = file1.files[0];             
           // var formData = new FormData();
           // formData.append('archivo1',archivo1);
         
        $.ajax({
            url: "documents",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                description: description,
                flow_id: flow,
                user_id: user,
                state_id : 1,
                summary: summary,
                docType:docType,
                code:code,
                route:route,
                content:content,
                version:version,
                mode:mode,
               // files: formData,              
            },

            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#cargandoDiv").css('display', 'none');
                $("#createDocument").modal('hide'); 
                $("#table").DataTable().destroy();
                $("#divTable").html(result);
                createDataTable("table");                          
                alerts('alerts', 'alert-content',"El documento " +  description +
                "ha sido agregado satisfactoriamente.", "alert-success");
                 me.data("requestRunning", false);   

            },
            error: function (request, status, error) {
                $("#cargandoDiv").css('display', 'none')
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                me.data("requestRunning", false);
                
            },
        });
    }   */
}



/**
 *  Set inputs in the edit form
 * 
 * @param {integer} id - document id
 * @param {string} name - name of the flow
 * @param {integer} flowId - flow id
 *  
 */
function edit(id,name,flowId) {
    $("select option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[id=idEdit]").val(id);
    $("input[name=descriptionEdit]").removeClass("is-invalid");
    $("input[name=descriptionEdit]").val(name);
    $("option[name=flowEdit" + flowId + "]").prop("selected", true);
    $("#edit").modal("show");

}



/**
 *  This function validates the inputs of the edit form in the browser
 *  
 */
function validaEdit() {
    var validado = true;
    if ($("input[name=descriptionEdit]").val() == "") {
        $("input[name=descriptionEdit]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=descriptionEdit]").removeClass("is-invalid");
    }
    return validado;
}


/**
 * Send an ajax request in order to update an specific flow 
 * 
 */
function ajaxUpdate() {
    if (validaEdit()) {
        var id = $("input[id=idEdit]").val();
        var description = $("input[name=descriptionEdit]").val();
        var flow = $("#flowCreate option:selected").val();
        $.ajax({
            url: "documents/{" + id + "}",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
                id: id,
                description: description,
                flow_id: flow,

            },
            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#edit").modal("hide");
                alerts('alerts', 'alert-content',"El departamento "+name+" ha sido actualizado satisfactoriamente", "alert-success");
                $("#cargandoDiv").css('display', 'none')
            },
            error: function(request, status, error) {
                alerts("Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                $("#cargandoDiv").css('display', 'none')
            }
        });
    }
}


$("html")
    .on("click", "#btnCreateDocument", function (e) {
        var td = e.currentTarget;
        typeContextMenu = "";
        idselect = "";
        descriptionEdit = "";
        var top = e.pageY - 10;
        var left = e.pageX - 90;

        $("#context-menu-create")
            .css({
                display: "block",
                top: top,
                left: left,
            })
            .addClass("show");       
        return false; //blocks default Webbrowser right click menu
    })
    .on("click", function () {
        $("#context-menu-create").removeClass("show").hide();
    });




function newDocument(e){
   var top = e.pageY - 10;
    var left = e.pageX - 90;

    (currentTable==1  && currentClassification.type==1)?$("#createClassification").show():$("#createClassification").hide()

    $("#context-menu-create")
        .css({
            display: "block",
            top: top,
            left: left,
        })
        .addClass("show");
}    



function createDoc(type){
    $('#docType').val(type);
if(type == 1 || type == 2){   
    $('#docName').css('display','block');  
    $('#docUpload').css('display','none'); 
     $('#createDocument').modal('show'); 
}
      
else if(type == 0){
    $('#docUpload').css('display','block'); 
    $('#docName').css('display','none'); 
   $('#uploadDocument').modal('show');    
}
else if(type == 3)

    typeContextMenu='';
    clearCreate();
    $('#create').modal('show'); 
}


