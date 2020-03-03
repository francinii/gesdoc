
//  editar
function clearDescription(){
    $("input[name=CreateDescription]").val("");
}




function edit(id, description) {
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    $("#edit").modal("show");
}

function ajaxCreate(){
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

/*

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
