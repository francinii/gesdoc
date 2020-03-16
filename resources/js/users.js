function edit(id, usuario , correo, nombre, rolid,instanciaid) {
    $("select option:selected" ).each(function(){
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });

;
    $("input[id=id_edit]").val(id);
    $("input[name=user_edit]").val(usuario);
    $("input[name=email_edit]").val(correo);
    $("input[name=name_edit]").val(nombre);
    $("option[name=rol_edit"+rolid+"]" ).prop("selected", true);
    $("option[name=instancia_edit"+instanciaid+"]" ).prop("selected", true);;
    $("#edit").modal("show");
}



function ajaxUpdate(){
    var id = $("input[id=id_edit]").val();
    var user = $("input[name=user_edit]").val();
    var email= $("input[name=email_edit]").val();
    var name = $("input[name=name_edit]").val();  
    var rol =  $( "select[name=rol_edit] option:selected" ).val();  
    var instancia =  $( "select[name=instancia_edit] option:selected" ).val();  
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
            rol_id: rol,
            instancia_id:instancia,
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