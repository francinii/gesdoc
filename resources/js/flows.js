
/** 
 * Clean the inputs
 * 
 */
function clearDescription() {
    $("input[name=CreateDescription]").val("");
    $("input[class=input_check_create]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}

/**
 * Send an ajax request in order to add a flow 
 * 
 * @param {integer} user - user id
 * 
 */
function ajaxCreate(user){    
    description =  $("input[id=CreateDescription]").val();
    $.ajax({
        url: "flows",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description:   description,
            user_id: user,     
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
 * Open a modal for a edit form
 * 
 * @param {integer} id - flow id
 * @param {string} description  - flow description
 * @param {integer} idUser  - user id 
 * 
 */
function edit(id, description, idUser) {
    $("#flowUsuario option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    $("option[name=flowUsuario" + idUser + "]").prop("selected", true);    
    $("#edit").modal("show");
}

/**
 * Send an ajax request in order to update an specific flow
 * 
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
