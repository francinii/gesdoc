
function obtenerDatos(){
    var username = $("input[name=username]").val();
    $('#buscando').modal('show')
    $.ajax({

        type:'get',

        url:'ldap/obtenerUsuario',

        data:{username:username},

        success:function(data){
            $('#buscando').modal('hide')
            var encondrado=data.encontrado;
            if(encondrado){
            $("input[name=name]").val(data.cn);
            $("input[name=email]").val(data.mail);
            }else{
                $('#error').modal('show')
            }

        },
        error: function (request, status, error) {
            $('#buscando').modal('hide')
            $('#error').modal('show')
            $("input[name=name]").val("");
            $("input[name=email]").val("");
        }

     });
}