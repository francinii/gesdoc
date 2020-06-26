/** 
 * Clean the create form
 * 
 */
function clearCreate() {
    $("input[name=nameCreate]").val("");
    
}

/** 
 * Validate the inputs in the create form
 * 
 */
function validaCreate() {
    var validado = true;
    if ($("input[name=nameCreate]").val() == "") {
        $("input[name=nameCreate]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=nameCreate]").removeClass("is-invalid");
      
    } 
    return validado;
}


/**
 * Send an ajax request in order to add a department
 *  
 */
function ajaxCreate() {
    var me = $(this);
 if (me.data("requestRunning"))
    return;
    
    if (validaCreate()) {       
        var description = $("input[name=nameCreate]").val();       

        $.ajax({
            url: "departments",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                description: description,            
            },
            beforeSend: function (xhr) { 
                me.data("requestRunning", true);
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");                
                $("#create").modal("hide");
                alerts('alerts', 'alert-content',"El departamento "+name+" ha sido agregado satisfactoriamente", "alert-success");
                
            },
            error: function(request, status, error) {
                    me.data("requestRunning", false);
                    $("#cargandoDiv").css('display', 'none')
                    alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                    alert(request.responseText);
                   
                
            }
        });
    }
}


/**
 * Open a modal to edit a role
 * 
 * @param {integer} id - department id
 * @param {string} name  - department name
 *    
 */
function edit(id,name) {
    $("select option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[id=idEdit]").val(id);
    $("input[name=nameEdit]").removeClass("is-invalid");
    $("input[name=nameEdit]").val(name);

    $("#edit").modal("show");
}


/**
 * Validate inputs in the edit form.  
 *    
 */
function validaEdit() {
    var validado = true;

    if ($("input[name=nameEdit]").val() == "") {
        $("input[name=nameEdit]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=nameEdit]").removeClass("is-invalid");
    }    
    return validado;
}
/**
 * Update a departament
 */

function ajaxUpdate() {
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    
    if (validaEdit()) {
        var id = $("input[id=idEdit]").val();
        var description = $("input[name=nameEdit]").val();
    
        $.ajax({
            url: "departments/{" + id + "}",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
                id: id,
                description: description,

            },
            beforeSend: function (xhr) { 
                me.data("requestRunning", true);
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#edit").modal("hide");
                alerts('alerts', 'alert-content',"El departamento "+description+" ha sido actualizado satisfactoriamente", "alert-success");
                
            },
            error: function(request, status, error) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                
            }
        });
    }
}
