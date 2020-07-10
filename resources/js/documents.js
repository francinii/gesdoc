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
    $("#others").val("");
    $("#others").removeClass("is-invalid");
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
        var others = $("#others").val();  ;
        
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
                others:others,
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


function clearUploadDoc() {
    $("#nameU").val("");
    $("#nameU").removeClass("is-invalid");
    $("#codeU").val("");
    $("#summaryU").val("");
    $("#summaryU").removeClass("is-invalid");
    $("#languajeU").val("");
    $("#languajeU").removeClass("is-invalid");
    $("#othersU").val("");
    $("#othersU").removeClass("is-invalid");
    $("#file").val("");
    $("#file").removeClass("is-invalid");
    $("#file_message").html("");
}


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
    if ($("#summaryU").val() == "") {
        $("#summaryU").addClass("is-invalid");
        validado = false;
    } else {
        $("#summaryU").removeClass("is-invalid");
    }
    if ($("#docType").val() == "") {
        $("#docType").addClass("is-invalid");
        validado = false;
    } else {
        $("#docType").removeClass("is-invalid");
    }
    if ($("#languajeU").val() == "") {
        $("#languajeU").addClass("is-invalid");
        validado = false;
    } else {
        $("#languajeU").removeClass("is-invalid");
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
 * 
 * @param {integer} mode - define if is a document for edit or for storage.  0-edit 1-storage
 * 
 */
function ajaxUploadDoc(mode) {
    var me = $(this);

    if (me.data("requestRunning"))
        return;
    if (validaUploadDoc()) {
        var flow = $("#flowCreateU option:selected").val();
        var classification = $("#classificationU option:selected").val();
        var description = $("#nameU").val();
        var summary = $("#summaryU").val();
        var type = $("#docType").val();
        var code  = $("#codeU").val();        
        var languaje = $("#languajeU").val();  
        var others = $("#othersU").val();  
        var file1 = $('#file')[0]
        var archivo = file1.files[0]; 

        if(type == 1)
            docType = 'docx';
        else if(type == 2)
            docType = 'xlsx';
        else{
            var fullname=archivo.name.split(".");
            docType=fullname.pop();
        }     
    
           
        var formData = new FormData();
        formData.append('X-CSRF-TOKEN"',$('meta[name="csrf-token"]').attr("content"));
        formData.append('_token',$("input[name=_token]").val(),   );
        formData.append('currentClassification',currentClassification.id);
        formData.append('currentTable',currentTable);
        formData.append('description',description);
        formData.append('flow_id',flow);
        formData.append('state_id',1);
        formData.append('summary',summary);
        formData.append('docType',docType);
        formData.append('code',code);
        formData.append('languaje',languaje);
        formData.append('classification',classification);
        formData.append('others',others);        
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
    var othersEditDoc=currentTd.parentNode.childNodes[19].innerText;
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
    
    $("#othersEditDoc").val(othersEditDoc);
    $("option[name=flowEditDoc" + flowId + "]").prop("selected", true);
    if(currentTable==2){
     var option='<option value="'+currentClassification.id+'" name ="DefaulclassificationEditDoc">'+currentClassification.description+'</option>'; 
     $("#classificationEditDoc").append(option);
     $("option[name=DefaulclassificationEditDoc]").prop("selected", true);
     $("#classificationEditDoc").prop("disabled", true );
    }else{
        $( "option[name=DefaulclassificationEditDoc]" ).remove();
        $("#classificationEditDoc").prop("disabled", false);
        $("option[name=classificationEditDoc" + classificationID + "]").prop("selected", true);
    }
   
   
 

    
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
        var others = $("#othersEditDoc").val();                   
           
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
                others:others,           
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
                createDataTableHome("table");                          
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
        $("#createSheet").show();
        $("#createClassification").hide();
    }
    else if(currentTable==2  && currentClassification.type==3 && (isCurrentUserOwner || CanCurrentUserEditar)){
        $("#createTxt").show();
        $("#createSheet").show();
        $("#createClassification").hide();
    }
    else{
        $("#createTxt").hide();
        $("#createSheet").hide();
        $("#createClassification").hide();
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

        $('#createDocument').modal('show'); 
    }
        
    else if(type == 0){
        clearUploadDoc();

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

function clone(){
    var me = $(this);
    if (me.data("requestRunning"))
        return;
    var description= descriptionEdit;
    $.ajax({
        url: "documents/clone/{" + idselect + "}",
        method: "get",
        data: {
            _token: $("input[name=_token]").val(),
            id:idselect,
            currentClassification: currentClassification.id,
            currentTable:currentTable,          
        },

        beforeSend: function (xhr) { 
            me.data("requestRunning", true);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function (result) {
            $("#cargandoDiv").css('display', 'none');
            me.data("requestRunning", false);   
            $("#table").DataTable().destroy();
            $("#divTable").html(result);
            createDataTableHome("table");                          
            alerts('alerts', 'alert-content',"El documento " +  description +
            " ha clonado", "alert-success")                              

        },
        error: function (request, status, error) {
            $("#cargandoDiv").css('display', 'none')
            me.data("requestRunning", false);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            alert(request.responseText);
            
            
        },
    });
    
}

function advancedSearchfilter(colum,element){
   var dataTable= $("#table").DataTable()
  
    if ( dataTable.column(colum).search() !== element.value ) {
        dataTable
            .column(colum)
            .search( element.value )
            .draw();
    }


}