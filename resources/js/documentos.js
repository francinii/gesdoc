function clearDescription(){
    $("input[name=CreateDescription]").val("");   
    
}


function ajaxCreate(usuario){  
    var flujo = $("#flujo_create option:selected" ).val(); 
    var descripcion = $("input[id=CreateDescription]").val();
    $.ajax({
        url: "documentos",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description: descripcion ,   
            flujoId: flujo,
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