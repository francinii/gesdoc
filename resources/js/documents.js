/** 
 * Clean the inputs
 * 
 */
function clearDescriptionDoc() {
    $("input[name=descriptionCreate]").val("");
    $("input[name=descriptionCreate]").removeClass("is-invalid");
    $("#code").val("");
    $("#summary").val("");
    $("#summary").removeClass("is-invalid");
    $("#languaje").val("");
    $("#languaje").removeClass("is-invalid");
    $("#othres").removeClass("is-invalid");
}


/**
 *  This function validates the inputs of the create form in the browser
 *  
 */
function validaCreateDoc() {
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
    if ($("#languaje").val() == "") {
        $("#languaje").addClass("is-invalid");
        validado = false;
    } else {
        $("#languaje").removeClass("is-invalid");
    }

    return validado;
}

/**
 * Send an ajax request in order to add a flow 
 * 
 * @param {integer} mode - define if is a document for edit or for storage.  0-edit 1-storage
 * 
 */
function ajaxCreateDoc(mode) {
    var me = $(this);

    if (me.data("requestRunning"))
        return;
    if (validaCreateDoc()) {
        var flow = $("#flowCreate option:selected").val();
        var classification = $("#classificationCreate option:selected").val();
        var description = $("#descriptionCreate").val();
        var summary = $("#summary").val();
        var type = $("#docType").val();
        var code  = $("#code").val();        
        var languaje = $("#languaje").val();  
        var othres = $("#othres").val();  ;
        
        if(type == 1)
            docType = 'docx';
        else if(type == 2)
            docType = 'xlsx';                  
           
        $.ajax({
            url: "documents",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                currentClassification: currentClassification.id,
                currentTable:currentTable,
                description: description,
                flow_id: flow,
                classification:classification,
                state_id : 1,
                summary: summary,
                docType:docType,
                code:code,
                languaje:languaje,
                othres:othres,
                mode:mode,                 
            },

            beforeSend: function (xhr) { 
                me.data("requestRunning", true);
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#cargandoDiv").css('display', 'none');
                me.data("requestRunning", false);   
                var type = $("#docType").val();            
                if(type == 1){
                    window.location="documents/textEditor";
                }else {
                    window.location="documents/spreadSheetEditor";
                }
                              

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


function clearDescriptionDoc() {
    $("input[name=descriptionCreate]").val("");
    $("input[name=descriptionCreate]").removeClass("is-invalid");
    $("#code").val("");
    $("#summary").val("");
    $("#summary").removeClass("is-invalid");
    $("#languaje").val("");
    $("#languaje").removeClass("is-invalid");
    $("#othres").removeClass("is-invalid");
}


/**
 *  This function validates the inputs of the create form in the browser
 *  
 */
function validaCreateDoc() {
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
    if ($("#languaje").val() == "") {
        $("#languaje").addClass("is-invalid");
        validado = false;
    } else {
        $("#languaje").removeClass("is-invalid");
    }

    return validado;
}

/**
 * Send an ajax request in order to upload a file to the server 
 * 
 * 
 * @param {integer} mode - define if is a document for edit or for storage.  0-edit 1-storage
 * 
 */
function ajaxUploadDoc(mode) {
    var me = $(this);

    if (me.data("requestRunning"))
        return;
    
        var flow = $("#flowCreateU option:selected").val();
        var classification = $("#classificationU option:selected").val();
        var description = $("#nameU").val();
        var summary = $("#summaryU").val();
        var type = $("#docType").val();
        var code  = $("#codeU").val();        
        var languaje = $("#languajeU").val();  
        var othres = $("#othresU").val();  

        if(type == 1)
            docType = 'docx';
        else if(type == 2)
            docType = 'xlsx';     
    
        var file1 = $('#file')[0]
        var archivo = file1.files[0];            
        var formData = new FormData();
        formData.append('X-CSRF-TOKEN"',$('meta[name="csrf-token"]').attr("content"));
        formData.append('_token',$("input[name=_token]").val(),   );
        formData.append('currentClassification',currentClassification.id);
        formData.append('description',description);
        formData.append('flow_id',flow);
        formData.append('state_id',1);
        formData.append('summary',summary);
        formData.append('docType',docType);
        formData.append('code',code);
        formData.append('languaje',languaje);
        formData.append('classification',classification);
        formData.append('othres',othres);        
        formData.append('mode',mode);
        formData.append('archivo',archivo);

        $.ajax({
            url: "documents",
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
                createDataTable("table");                          
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



/**
 *  Set inputs in the edit form
 * 
 * @param {integer} id - document id
 * @param {string} name - name of the flow
 * @param {integer} flowId - flow id
 *  
 */
function editDoc() {
    var flowId=currentTd.parentNode.childNodes[11].innerText;
    var summaryEditDoc=currentTd.parentNode.childNodes[13].innerText;
    var codeEditDoc=currentTd.parentNode.childNodes[15].innerText;
    var languajeEditDoc=currentTd.parentNode.childNodes[17].innerText;    
    var othresEditDoc=currentTd.parentNode.childNodes[19].innerText;
    var classificationID=currentClassification.id;
    $("select option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("#idEditDoc").val(idselect);
    $("#descriptionEditDoc").removeClass("is-invalid");
    $("#descriptionEditDoc").val(descriptionEdit);
    

    $("#codeEditDoc").val(codeEditDoc);
    $("#languajeEditDoc").val(languajeEditDoc);
    $("#summaryEditDoc").val(summaryEditDoc);
    
    $("#othresEditDoc").val(othresEditDoc);
    $("option[name=flowEditDoc" + flowId + "]").prop("selected", true);
    $("option[name=classificationEditDoc" + classificationID + "]").prop("selected", true);
    $("#editDocument").modal("show");

}



/**
 *  This function validates the inputs of the edit form in the browser
 *  
 */
function validaEditDoc() {
    var validado = true;
    if ($("#descriptionEditDoc").val() == "") {
        $("descriptionEditDoc").addClass("is-invalid");
        validado = false;
    } else {
        $("descriptionEditDoc").removeClass("is-invalid");
    }
    if ($("#summaryEditDoc").val() == "") {
        $("#summaryEditDoc").addClass("is-invalid");
        validado = false;
    } else {
        $("#summaryEditDoc").removeClass("is-invalid");
    }
    if ($("#languajeEditDoc").val() == "") {
        $("#languajeEditDoc").addClass("is-invalid");
        validado = false;
    } else {
        $("#languajeEditDoc").removeClass("is-invalid");
    }

    return validado;
}


/**
 * Send an ajax request in order to update an specific flow 
 * 
 */
function ajaxUpdateDoc() {
    

   var me = $(this);

    if (me.data("requestRunning"))
        return;
    if (validaEditDoc()) {
        var id=$("#idEditDoc").val();
        var flow = $("#flowEditDoc option:selected").val();
        var classification = $("#classificationEditDoc option:selected").val();
        var description = $("#descriptionEditDoc").val();
        var summary = $("#summaryEditDoc").val();
        var code  = $("#codeEditDoc").val();        
        var languaje = $("#languajeEditDoc").val();  
        var othres = $("#othresEditDoc").val();                   
           
        $.ajax({
            url: "documents/{" + id + "}",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
                id:id,
                currentClassification: currentClassification.id,
                currentTable:currentTable,
                classification:classification,
                description: description,
                flow_id: flow,
                summary: summary, 
                code:code,
                languaje:languaje,
                othres:othres,           
            },

            beforeSend: function (xhr) { 
                me.data("requestRunning", true);
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#cargandoDiv").css('display', 'none');
                me.data("requestRunning", false);   
                $("#editDocument").modal('hide'); 
                $("#table").DataTable().destroy();
                $("#divTable").html(result);
                createDataTable("table");                          
                alerts('alerts', 'alert-content',"El documento " +  description +
                "ha sido agregado satisfactoriamente, espere mientras se redirecciona al nuevo documento", "alert-success")                              

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
    $("#actionsMenu").hide();
    if(currentTable==1  && currentClassification.type==1){
    $("#createClassification").show();
    $("#createTxt").show();
    $("#createSheet").show();
    }
    else if(currentTable==1  && currentClassification.type==3){
        $("#createTxt").show();
        $("#createTxt").hide();
        $("#createSheet").hide();
        $("#actionsMenu").show();
        
    }
   

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
        clearDescriptionDoc();
        $('#docName').css('display','block');  
        $('#docUpload').css('display','none'); 
        $('#createDocument').modal('show'); 
    }
        
    else if(type == 0){
        clearDescriptionDoc();
        $('#docUpload').css('display','block'); 
        $('#docName').css('display','none'); 
    $('#uploadDocument').modal('show');    
    }
    else if(type == 3){

            typeContextMenu='';
            clearCreate();
            $('#create').modal('show'); 
    }
}


function selectDoc(e){

}
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