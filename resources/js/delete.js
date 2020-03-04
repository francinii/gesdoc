function ajaxDelete(id, url1,table){
    $.ajax({
        url: url1 + "/" + id,
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            _method:'DELETE',
            id:id,
        },
        success: function(result) {           
            $("#"+table).html(result);
           // $("#edit").modal("hide");
        },
        error: function (request, status, error) {
            alert(request.responseText);
        }
    });

}