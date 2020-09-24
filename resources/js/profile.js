/**
 * valide the inputs to edit a user
 */
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
 * Send an ajax request in order to update an specific user
 *
 */
function ajaxUpdate() {
    var me = $(this);
 if (me.data("requestRunning"))
    return;
    
    if (validaEdit()) {
        var id = $("input[id=user_edit]").val(); 
        var user=  $("input[id=user_edit]").val();     
        var email = $("input[name=email_edit]").val();
        var name = $("input[name=name_edit]").val();
        var role = -1;
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
                me.data("requestRunning", true);
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alerts('alerts', 'alert-content',
                    "El usuario " +
                        name +
                        " ha sido actualizado satisfactoriamente",
                    "alert-success"
                );
                $("#password_edit").attr("disabled", "disabled");
                $("input[name=password_edit]").val("");
                $("input[name=password_edit]").removeClass("is-invalid");
                $("#password_edit_message").html("");
                $("input[name=checkbox_password]").prop("checked", false);
            },
            error: function (request, status, error) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                //alert(request.responseText);
                
            },
        });
    }
}

/**
 *  abled and disable de password edit
 */
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