/**
 * Limpia los inputs dándonles un valor ""
 */
function clearDescription() {
    $("input[name=CreateDescription]").val("");

    $("input[class=input_check_create]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}

/**
 * Abre modal para editar un rol
 *
 * @param {integer} id - id del rol
 * @param {string} description  - Descripcion del rol
 * @param {array} permissions - Arreglo con la lista de permissions de la base de datos
 * @param {array} permissionsAsociados - Arreglo con la lista de permissions asociados
 */
function edit(id, description, permissions, permissionsAsociados) {
    $("#check_permissions").empty();
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    var check = "";
    permissions.forEach(element => {
        check = permissionsAsociados.find(elemento => elemento.id == element.id)
            ? "checked"
            : "";
        $("#check_permissions").append(
            '<div class="checkbox"><label for="check' +
                element.id +
                '"><input class="input_check_edit" id="check' +
                element.id +
                '" value="' +
                element.id +
                '" type="checkbox" ' +
                check +
                "> " +
                element.description +
                "</label></div>"
        );
    });
    $("#edit").modal("show");
}

/**
 * Envia una petición ajax, para agregar un rol
 */
function ajaxCreate() {
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

        success: function(result) {
            $("#table").html(result);
            $("#table")
                .DataTable()
                .destroy();
            createDataTable("table");
            $("#create").modal("hide");
            alerts(
                "El rol " +
                    description +
                    " ha sido agregado satisfactoriamente",
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
 * Envia una petición ajax, para actualizar un rol
 */
function ajaxUpdate() {
    var id = $("input[name=id]").val();
    var description = $("input[id=description]").val();
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

        success: function(result) {
            $("#table").html(result);
            $("#table")
                .DataTable()
                .destroy();
            createDataTable("table");
            $("#edit").modal("hide");
            alerts(
                "El rol " +
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

/**
 * Lista en una tabla dentro de un modal los usuarios o permisos asociados a un rol
 * seleccionado.
 *
 * @param {array} arreglo -arreglo que lista los permisos o usuarios
 * @param {string} roleDescripcion  - Descripcion del rol
 * @param {integer} codigo - El código indica si se listan usuarios
 * o permisos: código 1 -> lista permisos, código 2: -> lista usuarios.
 *
 */
function list(arreglo, roleDescripcion, codigo) {
    $(".body_table").empty(); //elimina los elementos anteriores de la tabla
    $(".head_table").empty(); //elimina los elementos anteriores de la tabla

    $("#list_role").text(roleDescripcion);
    codigo == 1
        ? $(".head_table").append(
              "<tr><th>Id</th><th>Permiso asocidado</th></tr>"
          )
        : $(".head_table").append(
              "<tr><th>Usuario</th><th>Nombre</th><th>Correo</th></tr>"
          );
    arreglo.forEach(element => {
        codigo == 1
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
