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
    return validado;
}

/**
 * Send an ajax request in order to add a flow 
 * 
 * @param {integer} user - user id
 * 
 */
function ajaxCreate(user) {
    if (validaCreate()) {
        var flow = $("#flowCreate option:selected").val();
        var descripcion = $("input[id=descriptionCreate]").val();
        $.ajax({
            url: "documents",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                description: descripcion,
                flow_id: flow,
                user_id: user
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
                alerts(
                    "El documento " +
                        description +
                        " ha sido creaado satisfactoriamente",
                    "alert-success"
                );
                $("#cargandoDiv").css('display', 'none')
            },

            error: function(request, status, error) {
                alert(request.responseText);
                alerts("Ha ocurrido un error inesperado.", "alert-danger");
                $("#cargandoDiv").css('display', 'none')
            }
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
                alerts("El departamento "+name+" ha sido actualizado satisfactoriamente", "alert-success");
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