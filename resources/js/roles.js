/**
 * Clean the inputs
 *
 */
function clearDescription() {
    $("input[name=CreateDescription]").val("");
    $("input[name=CreateDescription]").removeClass("is-invalid");
    $("input[class=input_check_create]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}

/**
 * Open a modal to edit a role
 *
 * @param {integer} id - rol id
 * @param {string} description  - rol description
 * @param {array} permissions - Array with a permissions list from the database
 * @param {array} asociatedPermissions -  Array with  asociate permissions list
 *
 */
function edit(id, description, asociatedPermissions) {
    $("input[class=input_check_edit]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
    $("input[name=editDescription]").removeClass("is-invalid");
    $("input[name=editDescription]").val(description);
    $("input[name=editId]").val(id);

    asociatedPermissions.forEach(element => {
        $("input[id=editCheck" + element.id + "]").prop("checked", true);
    });
    $("#edit").modal("show");
}

function validaCreate() {
    var validado = true;
    if ($("input[name=CreateDescription]").val() == "") {
        $("input[name=CreateDescription]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=CreateDescription]").removeClass("is-invalid");
    }
    return validado;
}

/**
 * Send an ajax request in order to add a role
 *
 */
function ajaxCreate() {
    var me = $(this);
 if (me.data("requestRunning"))
    return;
    
    if (validaCreate()) {
        description = $("input[id=CreateDescription]").val();
        var permissions = [];
        $("input[class=input_check_create]:checked").each(function() {
            permissions.push($(this).val());
        });
        $.ajax({
            url: "roles",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                description: description,
                permissions: permissions
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
                alerts('alerts', 'alert-content',
                    "El rol " +
                        description +
                        " ha sido agregado satisfactoriamente",
                    "alert-success"
                );
                
            },

            error: function(request, status, error) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alert(request.responseText);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                
            }
        });
    }
}

function validaEdit() {
    var validado = true;
    if ($("input[name=editDescription]").val() == "") {
        $("input[name=editDescription]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=editDescription]").removeClass("is-invalid");
    }
    return validado;
}

/**
 * Send an ajax request in order to update an specific role
 *
 */
function ajaxUpdate() {
    var me = $(this);
 if (me.data("requestRunning"))
    return;

    if (validaEdit()) {
        var id = $("input[name=editId]").val();
        var description = $("input[id=editDescription]").val();
        var permissions = [];

        $("input[class=input_check_edit]:checked").each(function() {
            permissions.push($(this).val());
        });
        $.ajax({
            url: "roles/{" + id + "}",
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
                id: id,
                description: description,
                permissions: permissions
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
                alerts('alerts', 'alert-content',
                    "El rol " +
                        description +
                        " ha sido actualizado satisfactoriamente",
                    "alert-success"
                );
                
            },

            error: function(request, status, error) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alert(request.responseText);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                
            }
        });
    }
}

/**
 * List a table inside a modal with the permissions or users asocited to an
 * specific role.
 *
 * @param {array} array  - Array that  list the users or permissions
 * @param {string} roleDescripcion  - Role description
 * @param {integer} code - This code means if is a user or permission list.
 * If the code is  1 -> list the permissions and if it is 2: -> list user.
 *
 */
function list(array, roleDescripcion, code) {
    $(".body_table").empty(); //Delete the element before in a table
    $(".head_table").empty(); //Delete the element before in a table

    $("#list_role").text(roleDescripcion);
    code == 1
        ? $(".head_table").append(
              "<tr><th>Id</th><th>Permiso asocidado</th></tr>"
          )
        : $(".head_table").append(
              "<tr><th>Usuario</th><th>Nombre</th><th>Correo</th></tr>"
          );
    array.forEach(element => {
        code == 1
            ? $(".body_table").append(
                  "<tr><td>" +
                      element.id +
                      "</td><td>" +
                      element.description +
                      "</td></tr>"
              )
            : $(".body_table").append(
                  "<tr><td>" +
                      element.username +
                      "</td><td>" +
                      element.name +
                      "</td><td>" +
                      element.email +
                      "</td></tr>"
              );
    });
    $("#list").modal("show");
}
