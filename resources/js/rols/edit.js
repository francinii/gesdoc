
//  editar
function clearDescription(){
    $("input[name=CreateDescription]").val("");
}

function edit(id, description , permisos, permisosAsociados) {
    $("#check_permisos").empty();
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    var check = "";
    permisos.forEach(element => {
        check = permisosAsociados.find(elemento => elemento.id == element.id) ? "checked": "";     
        $( "#check_permisos" ).append( '<div class="checkbox"><label for="check'+element.id+'"><input class="check" id="check'+element.id+'" type="checkbox" '+check+'> '+ element.description+'</label></div>' ); 
    });
   
   
    $("#edit").modal("show");
}

function ajaxCreate(){
   // var chequeados= $("input[class=input_check_create]").val();
    $("input[class=input_check_create]:checked").each(function(){
        //cada elemento seleccionado
        alert($(this).val());
    });
    $.ajax({
        url: "rols",
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            description:  $("input[id=CreateDescription]").val(),
            
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




function ajaxUpdate(){
    var id = $("input[name=id]").val();
    var description = $("input[id=description]").val();
    $.ajax({
        url: "rols/{" + id+"}",
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            _method:'PATCH',
            id:id,
            description:  description,
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

/*

function list(arreglo, rolDescripcion, codigo) {
  // permisos
  //  var per = permisos[0];
    $(".body_table").empty(); //elimina los elementos anteriores
    $(".head_table").empty(); //elimina los elementos anteriores
    $('#list_rol').text(rolDescripcion);
    if(codigo == 1){
        $( ".head_table" ).append( "<tr><th>Id</th><th>Permiso asocidado</th></tr>" );  
        arreglo.forEach(element => {                 
            $( ".body_table" ).append( "<tr><td>"+ element.id +"</td><td>"+ element.description +"</td></tr>" ); 
        });
    }else if(codigo == 2){
        $( ".head_table" ).append( "<tr><th>Usuario</th><th>Nombre</th><th>Correo</th></tr>" );
        arreglo.forEach(element => {
            $( ".body_table" ).append( "<tr><td>"+ element.username +"</td><td>"+ element.name +"</td><td>"+ element.email +"</td></tr>" ); 
        });
    }   
   
    $("#list").modal("show");    
}

function ajaxDelete(id){
    $.ajax({
        url: "rols/" + id,
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            _method:'DELETE',
            id:id,
        },
        success: function(result) {
            
            $("#table").html(result);
            $("#edit").modal("hide");
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });

} */
