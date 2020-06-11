function validaEdit() {
    var validado = true;
    if ($("input[name=user_edit]").val() == "") {
        $("input[name=user_edit]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=user_edit]").removeClass("is-invalid");
        $("#user_create_message").html("");
    }
    if ($("input[name=name_edit]").val() == "") {
        $("input[name=name_edit]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=name_edit]").removeClass("is-invalid");
    }
    if ($("input[name=email_edit]").val() == "") {
        $("input[name=email_edit]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=email_edit]").removeClass("is-invalid");
    }
    if (!ldap) {
        if (
            $("input[name=checkbox_password]").is(":checked") &&
            $("input[name=password_edit]").val().length < 7
        ) {
            $("input[name=password_edit]").addClass("is-invalid");
            $("#password_edit_message").html(
                "La contraseña debe tener al menos 8 digitos"
            );
            validado = false;
        } else {
            $("input[name=password_edit]").removeClass("is-invalid");
            $("#password_edit_message").html("");
        }
    }
    return validado;
}

/**
 * Change the classes of the inputs depending on if the entrance
 * is valid or not.
 *
 * 
 * @param {string} user  - user description
 * @param {string} email - user's email
 * @param {string} name - user's name
 * @param {string} roleId - role asociated to the user
 * @param {string} departmentId - department asociated to the user
 *
 */
function edit(user, email, name, roleId, departmentId) {
    $("select option:selected").each(function () {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=user_edit]").removeClass("is-invalid");
    $("input[name=email_edit]").removeClass("is-invalid");
    $("input[name=name_edit]").removeClass("is-invalid");
    $("input[name=password_edit]").removeClass("is-invalid");
    $("#password_create_message").html("");
    
    $("input[name=user_edit]").val(user);
    $("input[name=email_edit]").val(email);
    $("input[name=name_edit]").val(name);
    $("option[name=role_edit" + roleId + "]").prop("selected", true);
    $("option[name=department_edit" + departmentId + "]").prop(
        "selected",
        true
    );
    $("#password_edit").attr("disabled", "disabled");
    $("input[name=checkbox_password]").prop("checked", false);
    $("input[name=password_edit]").val("");
    $("#edit").modal("show");
}

function obtenerDatos() {
    var username = $("input[name=user_create]").val();
    $("#buscando").modal("show");
    $.ajax({
        type: "get",
        url: "ldap/obtenerUsuario",
        data: { username: username },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function (data) {
            $("#buscando").modal("hide");
            var encondrado = data.encontrado;
            if (encondrado) {
                $("input[name=name_create]").val(data.cn);
                $("input[name=email_create]").val(data.mail);
            } else {
                $("#alertModalTitle").text('Error');
                $("#alertModalDescription").text('Ha ocurrido un error inesperado.');
                $("#alertModal").modal("show");
            }
            $("#cargandoDiv").css('display', 'none')
        },
        error: function (request, status, error) {
            $("#buscando").modal("hide");
            $("#alertModalTitle").text('Error');
            $("#alertModalDescription").text('Ha ocurrido un error inesperado.');
            $("#alertModal").modal("show");
            $("input[name=name_create]").val("");
            $("input[name=email_create]").val("");
            $("#cargandoDiv").css('display', 'none')
        },
    });
}

/**
 * Send an ajax request in order to update an specific user
 *
 */
function ajaxUpdate() {
    if (validaEdit()) {
        var id = $("input[id=user_edit]").val(); 
        var user=  $("input[id=user_edit]").val();     
        var email = $("input[name=email_edit]").val();
        var name = $("input[name=name_edit]").val();
        var role = $("select[name=role_edit] option:selected").val();
        var department = $(
            "select[name=department_edit] option:selected"
        ).val();
        var password = $("input[name=password_edit]").val();
        var updatepassword = $("input[name=checkbox_password]").is(":checked");
        $.ajax({
            url: "users/{" + id + "}",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
               
                name: name,
                username: user,
                email: email,
                role_id: role,
                department_id: department,
                updatePassword: updatepassword,
                password: password,
            },
            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#table").html(result);
                $("#table").DataTable().destroy();
                createDataTable("table");
                $("#edit").modal("hide");
                alerts('alerts', 'alert-content',
                    "El usuario " +
                        name +
                        " ha sido actualizado satisfactoriamente",
                    "alert-success"
                );
                $("#cargandoDiv").css('display', 'none')
            },
            error: function (request, status, error) {
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                $("#cargandoDiv").css('display', 'none')
            },
        });
    }
}

function clearCreate() {
    $("input[name=user_create]").val("");
    $("input[name=email_create]").val("");
    $("input[name=name_create]").val("");
    $("input[name=password_create]").val("");
    $("input[name=user_create]").removeClass("is-invalid");
    $("input[name=email_create]").removeClass("is-invalid");
    $("input[name=name_create]").removeClass("is-invalid");
    $("input[name=password_create]").removeClass("is-invalid");
    $("#password_create_message").html("");
    $("#user_create_message").html("");
}

function validaCreate() {
    var validado = true;
    if ($("input[name=user_create]").val() == "") {
        $("input[name=user_create]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=user_create]").removeClass("is-invalid");
        $("#user_create_message").html("");
    }
    if ($("input[name=name_create]").val() == "") {
        $("input[name=name_create]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=name_create]").removeClass("is-invalid");
    }
    if ($("input[name=email_create]").val() == "") {
        $("input[name=email_create]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=email_create]").removeClass("is-invalid");
    }
    if (!ldap) {
        if ($("input[name=password_create]").val().length < 7) {
            $("input[name=password_create]").addClass("is-invalid");
            $("#password_create_message").html(
                "La contraseña debe tener al menos 8 digitos"
            );
            validado = false;
        } else {
            $("input[name=password_create]").removeClass("is-invalid");
            $("#password_create_message").html("");
        }
    }
    return validado;
}

/**
 * Send an ajax request in order to update an specific user
 *
 */
function ajaxCreate() {
    if (validaCreate()) {
        var user = $("input[name=user_create]").val();
        var name = $("input[name=name_create]").val();
        var email = $("input[name=email_create]").val();
        var role = $("select[name=role_create] option:selected").val();
        var department = $(
            "select[name=department_create] option:selected"
        ).val();
        var password = $("input[name=password_create]").val();

        $.ajax({
            url: "users",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                name: name,
                username: user,
                email: email,
                role_id: role,
                department_id: department,
                password: password,
            },
            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                $("#table").html(result);
                $("#table").DataTable().destroy();
                createDataTable("table");
                $("#create").modal("hide");
                alerts('alerts', 'alert-content',
                    "El usuario " +
                        name +
                        " ha sido agregado satisfactoriamente",
                    "alert-success"
                );
                $("#cargandoDiv").css('display', 'none')
            },
            error: function (request, status, error) {
                var user = request.responseJSON["errors"]["username"];
                if (user[0] == "The username has already been taken.") {
                    $("input[name=user_create]").addClass("is-invalid");
                    $("#user_create_message").html("El usuario ya existe");
                } else {
                    alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                    alert(request.responseText);
                }
                $("#cargandoDiv").css('display', 'none')
            },
        });
    }
}

function change_password() {
    if ($("#password_edit").attr("disabled") == "disabled") {
        $("#password_edit").removeAttr("disabled");
    } else {
        $("#password_edit").attr("disabled", "disabled");
        $("input[name=password_edit]").val("");
        $("input[name=password_edit]").removeClass("is-invalid");
        $("#password_edit_message").html("");
    }
}

//Función que lista en una tabla
//código 1: lista permisos
//código 2: lista usuarios
/*function list(arreglo, roleDescripcion, codigo) {
    $(".body_table").empty(); //elimina los elementos anteriores
    $(".head_table").empty(); //elimina los elementos anteriores
    $("#list_role").text(roleDescripcion);

    codigo == 1
        ? $(".head_table").append(
              "<tr><th>Id</th><th>Permiso asocidado</th></tr>"
          )
        : $(".head_table").append(
              "<tr><th>Usuario</th><th>Nombre</th><th>Correo</th></tr>"
          );

    arreglo.forEach(element => {
        codigo == 1 //Tabla de permisos
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
}*/
