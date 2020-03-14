function edit(id, usuario , correo, nombre, rolid, rols) {
    $("#rol_edit").empty();
    $("input[id=edit_id]").val(id);
    $("input[name=user]").val(usuario);
    $("input[name=email]").val(correo);
    $("input[name=name]").val(nombre);    
    rols.forEach(element => {       
        selected = rolid == element.id ? "selected": "";     
        $( "#rol_edit" ).append( '<option value="'+element.id+'" name ="'+element.id+'" '+selected+'>'+element.description+'</option>'); 
    });     
    $("#edit").modal("show");
}



function ajaxUpdate(){
    var id = $("input[id=edit_id]").val();
    var user = $("input[name=user]").val();
    var email= $("input[name=email]").val();
    var name = $("input[name=name]").val();  
    var rol =  $( "select[name=rol] option:selected" ).val();   
    $.ajax({
        url: "users/{" + id+"}",
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            _method:'PATCH',
            id:id,
            name:  name,
            username:  user,
            email:  email,
            rol_id: rol
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


//  editar
function clearDescription(){
    $("input[name=CreateDescription]").val("");   
    $("input[class=input_check_create]:checked").each(function(){
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}

function ajaxCreate(){
    var permisos=[];
        $("input[class=input_check_create]:checked").each(function(){
        //cada elemento seleccionado
        permisos.push($(this).val());
    });
    $.ajax({
        url: "rols",
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            description:  $("input[id=CreateDescription]").val(),
            permisos:permisos,
            
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


//Función que lista en una tabla 
//código 1: lista permisos
//código 2: lista usuarios
function list(arreglo, rolDescripcion, codigo) {
 
    $(".body_table").empty(); //elimina los elementos anteriores
    $(".head_table").empty(); //elimina los elementos anteriores
    $('#list_rol').text(rolDescripcion);

    codigo == 1 ?
    $( ".head_table" ).append( "<tr><th>Id</th><th>Permiso asocidado</th></tr>" ):
    $( ".head_table" ).append( "<tr><th>Usuario</th><th>Nombre</th><th>Correo</th></tr>" );             
    
    arreglo.forEach(element => {  
        codigo == 1 ?   //Tabla de permisos   
        $( ".body_table" ).append( "<tr><td>"+ element.id +"</td><td>"+ element.description +"</td></tr>" ): 
        $( ".body_table" ).append( "<tr><td>"+ element.username +"</td><td>"+ element.name +"</td><td>"+ element.email +"</td></tr>" ); 
     
    });   
  
    $("#list").modal("show");    
}