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
        else if(type == 3)
            docType = 'pptx';                 
           
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
                $("#createDocument").modal('hide'); 
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
        else if(type == 3)
            docType = 'pptx';
        else{
            var fullname=archivo.name.split(".");
            docType=fullname.pop();
        }     
    
           
        var formData = new FormData();
        formData.append('X-CSRF-TOKEN"',$('meta[name="csrf-token"]').attr("content"));
        formData.append('_token',$("input[name=_token]").val());
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
    var flowId=currentTd.parentNode.childNodes[13].innerText;
    var summaryEditDoc=currentTd.parentNode.childNodes[15].innerText;
    var codeEditDoc=currentTd.parentNode.childNodes[17].innerText;
    var languajeEditDoc=currentTd.parentNode.childNodes[19].innerText;    
    var othersEditDoc=currentTd.parentNode.childNodes[21].innerText;
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
/**
 * open the context menu in home's menu
 */

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


/**
 * 
 * @param {elemet} e 
 * open the context menu in home's menu
 */

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

/**
 * 
 * @param {int} type  create a new document 1 docx 2 xlsx 0 upload 
 */

function createDoc(type){
    $('#docType').val(type);
    if( type > 0 && type < 4 ){   
        clearDescriptionDoc();

        $('#createDocument').modal('show'); 
    }
        
    else if(type == 0){
        clearUploadDoc();

    $('#uploadDocument').modal('show');    
    }
    else if(type == 4){

            typeContextMenu='';
            clearCreate();
            $('#create').modal('show'); 
    }
}


/**
 * put the name of file in upload file 
 */
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


/**
 * Clonea a document select
 */
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

/**
 * 
 * @param {int} colum of the table for filter
 * @param {string} element fro search
 */

function advancedSearchfilter(colum,element){
   var dataTable= $("#table").DataTable()
  
    if ( dataTable.column(colum).search() !== element.value ) {
        dataTable
            .column(colum)
            .search( element.value )
            .draw();
    }

}
/**
 * 
 * @param {int} id of de document
 */

function openDocument(id,flow){    
    var me = $(this);

    if (me.data("requestRunning"))
        return;

    if(flow!=null){
        $('#alertModalTitle').html('Documento en flujo');
        $('#alertModalDescription').html('El documento se encuentra en flujo por lo que no puede ser editado hasta que salga, si tiene permisos puede buscarlo en la sección de documentos en flujo');
        $('#alertModal').modal('show'); 
        return
    }
        var form = document.createElement("form");
        form.setAttribute("id", "OpenDocumentForm");
        form.setAttribute("method", "get");
        form.setAttribute("action", "wopiHost");
      //  form.setAttribute("action", "documents/open/"+id);
   //     form.setAttribute("action", "documents/open/"+id);
        form.setAttribute("target", "_blank");
    
        //Hidden Field
        var hiddenField = document.createElement("input");      
        var hiddenField1 = document.createElement("input");
        var hiddenField2 = document.createElement("input");
        var hiddenField3 = document.createElement("input");
        var hiddenField4 = document.createElement("input");

        //id
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("id", "id");
        hiddenField.setAttribute("name", "id");
        hiddenField.setAttribute("value", id); 

        //edit
        hiddenField1.setAttribute("type", "hidden");
        hiddenField1.setAttribute("id", "edit");
        hiddenField1.setAttribute("name", "edit");
        hiddenField1.setAttribute("value", "1");    
        //token   
        hiddenField2.setAttribute("type", "hidden");
        hiddenField2.setAttribute("id", "_token");
        hiddenField2.setAttribute("name", "_token");
        hiddenField2.setAttribute("value", $("input[name=_token]").val());  

        // mode home   
        hiddenField3.setAttribute("type", "hidden");
        hiddenField3.setAttribute("id", "mode");
        hiddenField3.setAttribute("name", "mode");
        hiddenField3.setAttribute("value", 1);  

        
        // version   
        hiddenField4.setAttribute("type", "hidden");
        hiddenField4.setAttribute("id", "version");
        hiddenField4.setAttribute("name", "version");
        hiddenField4.setAttribute("value", "last"); 
       

        //form.appendChild(hiddenField);  
        form.appendChild(hiddenField); 
        form.appendChild(hiddenField1);   
        form.appendChild(hiddenField2); 
        form.appendChild(hiddenField3); 
        form.appendChild(hiddenField4); 
        document.body.appendChild(form);
        form.submit();
        $( "#OpenDocumentForm" ).remove();

}



