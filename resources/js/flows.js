/**
 * Limpia los inputs dandonles un valor ""
 */
function clearDescription() {
    $("input[name=CreateDescription]").val("");
    $("input[class=input_check_create]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}

/**
 * Envia una petición ajax, para agregar un flujo
 *
 * @param {integer} usuario - id del usuario que crea el flujo *
 */
function ajaxCreate(usuario) {
    description = $("input[id=CreateDescription]").val();
    $.ajax({
        url: "flows",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description: description,
            user_id: usuario
        },

        success: function(result) {
            $("#table").html(result);
            $("#table")
                .DataTable()
                .destroy();
            createDataTable("table");
            $("#create").modal("hide");
            alerts(
                "El flujo " +
                    description +
                    " ha sido creado satisfactoriamente",
                "alert-success"
            );
        },

        error: function(request, status, error) {
            alert(request.responseText);
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
        }
    });
}

/**
 * Abre modal para editar un rol
 *
 * @param {integer} id - id del flujo
 * @param {string} description  - Descripcion del flujo
 */
function edit(id, description, idUser) {
    $("#flowUsuario option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    //idUser =$("input[id=idUser]").val();
    $("option[name=flowUsuario" + idUser + "]").prop("selected", true);
    //usuarios.forEach(element => {

    // });
    $("#edit").modal("show");
}

/**
 * Envia una petición ajax, para actualizar un flujo
 */
function ajaxUpdate() {
    var id = $("input[name=id]").val();
    var description = $("input[id=description]").val();
    var user = $("select[name=flowUsuario] option:selected").val();

    $.ajax({
        url: "flows/{" + id + "}",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            _method: "PATCH",
            id: id,
            description: description,
            user_id: user
        },

        success: function(result) {
            $("#table").html(result);
            $("#table")
                .DataTable()
                .destroy();
            createDataTable("table");
            $("#edit").modal("hide");
            alerts(
                "El flujo " +
                    description +
                    " ha sido actualizado satisfactoriamente",
                "alert-success"
            );
        },

        error: function(request, status, error) {
            alert(request.responseText);
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
        }
    });
}
