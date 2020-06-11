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
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");                
                $("#create").modal("hide");
                alerts("El departamento "+name+" ha sido agregado satisfactoriamente", "alert-success");
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
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#edit").modal("hide");
                alerts("El departamento "+description+" ha sido actualizado satisfactoriamente", "alert-success");
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
