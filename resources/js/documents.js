/** 
 * Clean the inputs
 * 
 */
function clearDescription() {
    $("input[name=descriptionCreate]").val("");
}

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
            },

            error: function(request, status, error) {
                alert(request.responseText);
                alerts("Ha ocurrido un error inesperado.", "alert-danger");
            }
        });
    }
}


function edit(id,nombre,flowId) {
    $("select option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);

    });
    $("input[id=idEdit]").val(id);
    $("input[name=descriptionEdit]").removeClass("is-invalid");
    $("input[name=descriptionEdit]").val(nombre);
    $("option[name=flowEdit" + flowId + "]").prop("selected", true);
    $("#edit").modal("show");

}




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
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#edit").modal("hide");
                alerts("El departamento "+name+" ha sido actualizado satisfactoriamente", "alert-success");
            },
            error: function(request, status, error) {
                alerts("Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
            }
        });
    }
}