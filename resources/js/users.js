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

    return validado;
}

function edit(id, usuario, correo, nombre, roleid, instanciaid) {
    $("select option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=user_edit]").removeClass("is-invalid");
    $("input[name=email_edit]").removeClass("is-invalid");
    $("input[name=name_edit]").removeClass("is-invalid");
    $("input[name=password_edit]").removeClass("is-invalid");
    $("#password_create_message").html("");
    $("input[id=id_edit]").val(id);
    $("input[name=user_edit]").val(usuario);
    $("input[name=email_edit]").val(correo);
    $("input[name=name_edit]").val(nombre);
    $("option[name=role_edit" + roleid + "]").prop("selected", true);
    $("option[name=instancia_edit" + instanciaid + "]").prop("selected", true);
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
        success: function(data) {
            $("#buscando").modal("hide");
            var encondrado = data.encontrado;
            if (encondrado) {
                $("input[name=name_create]").val(data.cn);
                $("input[name=email_create]").val(data.mail);
            } else {
                $("#error").modal("show");
            }
        },
        error: function(request, status, error) {
            $("#buscando").modal("hide");
            $("#error").modal("show");
            $("input[name=name_create]").val("");
            $("input[name=email_create]").val("");
        }
    });
}

function ajaxUpdate() {
    if (validaEdit()) {
        var id = $("input[id=id_edit]").val();
        var user = $("input[name=user_edit]").val();
        var email = $("input[name=email_edit]").val();
        var name = $("input[name=name_edit]").val();
        var role = $("select[name=role_edit] option:selected").val();
        var instancia = $("select[name=instancia_edit] option:selected").val();
        var password = $("input[name=password_edit]").val();
        var updatepassword = $("input[name=checkbox_password]").is(":checked");
        $.ajax({
            url: "users/{" + id + "}",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
                id: id,
                name: name,
                username: user,
                email: email,
                role_id: role,
                instancia_id: instancia,
                updatePassword: updatepassword,
                password: password
            },
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#edit").modal("hide");
            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    }
}

//  editar
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

    return validado;
}

function ajaxCreate() {
    if (validaCreate()) {
        var user = $("input[name=user_create]").val();
        var name = $("input[name=name_create]").val();
        var email = $("input[name=email_create]").val();
        var role = $("select[name=role_create] option:selected").val();
        var instancia = $(
            "select[name=instancia_create] option:selected"
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
                instancia_id: instancia,
                password: password
            },
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#create").modal("hide");
            },
            error: function(request, status, error) {
                var user = request.responseJSON["errors"]["username"];
                if (user[0] == "The username has already been taken.") {
                    $("input[name=user_create]").addClass("is-invalid");
                    $("#user_create_message").html("El usuario ya existe");
                } else {
                    alert(request.responseText);
                }
            }
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
function list(arreglo, roleDescripcion, codigo) {
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
}

$(document).ready(function() {
    createDataTable("table");
});
