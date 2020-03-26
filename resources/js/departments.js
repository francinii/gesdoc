function clearCreate() {
    $("input[name=nameCreate]").val("");
    
}

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
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");                
                $("#create").modal("hide");
                alerts("El departamento "+name+" ha sido agregado satisfactoriamente", "alert-success");
            },
            error: function(request, status, error) {
                
                    alerts("Ha ocurrido un error inesperado.", "alert-danger");
                    alert(request.responseText);
                
            }
        });
    }
}

function edit(id,nombre) {
    $("select option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[id=idEdit]").val(id);
    $("input[name=nameEdit]").removeClass("is-invalid");
    $("input[name=nameEdit]").val(nombre);

    $("#edit").modal("show");
}

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
