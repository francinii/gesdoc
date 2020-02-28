
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

}
