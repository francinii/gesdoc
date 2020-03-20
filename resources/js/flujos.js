/**
 * Limpia los inputs dandonles un valor "" 
 */
function clearDescription(){
    $("input[name=CreateDescription]").val("");   
    $("input[class=input_check_create]:checked").each(function(){
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}


/**
 * Envia una petición ajax, para agregar un flujo  
 * 
 * @param {integer} usuario - id del usuario que crea el flujo * 
 */
function ajaxCreate(usuario){    
    $.ajax({
        url: "flujos",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description:  $("input[id=CreateDescription]").val(),   
            userId: usuario,     
        },

        success: function(result) {            
            $("#table").html(result);
            $("#create").modal("hide");
        },

        error: function (request, status, error) {
            alert(request.responseText);
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
    $("#flujoUsuario option:selected" ).each(function(){
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    //idUser =$("input[id=idUser]").val();
    $("option[name=flujoUsuario"+idUser+"]" ).prop("selected", true);
    //usuarios.forEach(element => {

    // });  
    $("#edit").modal("show");
}


/**
 * Envia una petición ajax, para actualizar un flujo  
 */
function ajaxUpdate(){
    var id = $("input[name=id]").val();
    var description = $("input[id=description]").val();
    var user =  $( "select[name=flujoUsuario] option:selected" ).val(); 

    $.ajax({
        url: "flujos/{" + id+"}",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            _method:'PATCH',
            id:id,
            description:  description,
            userId:user,
        },

        success: function(result) {            
            $("#table").html(result);
            $("#edit").modal("hide");
        },

        error: function (request, status, error) {
            alert(request.responseText);
        }
    });
}