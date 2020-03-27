/** 
 * Clean the inputs
 * 
 */
function clearDescription(){
    $("input[name=CreateDescription]").val("");   
    $("input[class=input_check_create]:checked").each(function(){
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
function edit(id, description , permissions, asociatedPermissions) {
    $("#check_permissions").empty();
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    var check = "";
    permissions.forEach(element => {
        check = asociatedPermissions.find(elemento => elemento.id == element.id) ? "checked": "";     
        $( "#check_permissions" ).append( '<div class="checkbox"><label for="check'+element.id+'"><input class="input_check_edit" id="check'+element.id+'" value="'+element.id+'" type="checkbox" '+check+'> '+ element.description+'</label></div>' ); 
    });  
    $("#edit").modal("show");
}


/**
 * Send an ajax request in order to add a role
 *  
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
 * Send an ajax request in order to update an specific role
 * 
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
 * List a table inside a modal with the permissions or users asocited to an 
 * specific role.  
 * 
 * @param {array} array  - Array that  list the users or permissions
 * @param {string} roleDescripcion  - Role description
 * @param {integer} code - This code means if is a user or permission list.
 * If the code is  1 -> list the permissions and if it is 2: -> list user.  
 * 
 */
function list(array, roleDescripcion, code ) { 
    $(".body_table").empty(); //Delete the element before in a table
    $(".head_table").empty(); //Delete the element before in a table

    $('#list_role').text(roleDescripcion);
    code  == 1 ?
    $( ".head_table" ).append( "<tr><th>Id</th><th>Permiso asocidado</th></tr>" ):
    $( ".head_table" ).append( "<tr><th>Usuario</th><th>Nombre</th><th>Correo</th></tr>" );             
    array.forEach(element => {  
        code  == 1 ?     
        $( ".body_table" ).append( "<tr><td>"+ element.id +"</td><td>"+ element.description +"</td></tr>" ): 
        $( ".body_table" ).append( "<tr><td>"+ element.username +"</td><td>"+ element.name +"</td><td>"+ element.email +"</td></tr>" ); 
    });     
    $("#list").modal("show");    
}
