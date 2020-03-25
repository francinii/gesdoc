function clearDescription(){
    $("input[name=CreateDescription]").val("");   
    
}


function ajaxCreate(usuario){  
    var flow = $("#flow_create option:selected" ).val(); 
    var descripcion = $("input[id=CreateDescription]").val();
    $.ajax({
        url: "documents",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description: descripcion ,   
            flow_id: flow,
            user_id: usuario,     
        },

        success: function(result) {            
            $("#table").html(result);
            $("#create").modal("hide");
            alerts("El documento "+description+" ha sido creaado satisfactoriamente", "alert-success");
        },

        error: function (request, status, error) {
            alert(request.responseText);
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
        }
    });

}