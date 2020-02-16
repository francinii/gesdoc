
function obtenerDatos(){
    var username = $("input[name=username]").val();
    $.ajax({

        type:'get',

        url:'ldap/obtenerUsuario',

        data:{username:username},

        success:function(data){

            $("input[name=name]").val(data.cn);
            $("input[name=email]").val(data.mail);

        }

     });
}