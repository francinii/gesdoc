function createDataTable(table) {
    $("#" + table).dataTable({
        lengthChange: false,
        language: {
            decimal: "",
            emptyTable: "No hay información",
            info: "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            infoEmpty: "Mostrando 0 to 0 of 0 Entradas",
            infoFiltered: "(Filtrado de _MAX_ total entradas)",
            infoPostFix: "",
            thousands: ",",
            lengthMenu: "Mostrar _MENU_ Entradas",
            loadingRecords: "Cargando...",
            processing: "Procesando...",
            search: "Buscar:",
            zeroRecords: "Sin resultados encontrados",
            paginate: {
                first: "Primero",
                last: "Ultimo",
                next: "Siguiente",
                previous: "Anterior"
            }
        }
    });
}

function confirmDelete(id, url1,table,mensaje){
    $( "#mensajeConfirmar" ).html( "<p>"+mensaje+"</p>" );  
    $("#confirmarButton").attr("onClick","ajaxDelete("+id+",'"+url1+"','"+table+"')");
    $("#confirmar").modal("show");
}


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
            $("#"+table).DataTable().destroy();
            createDataTable(table);
            $("#confirmar").modal("hide");
            alerts("Elemento eliminado correctamente.", "alert-success");
        },
        error: function (request, status, error) {    
            $("#confirmar").modal("hide");        
            alerts("Ha ocurrido un error al intentar eliminar el elemento.", "alert-danger");
            alert(request.responseText);
        }
    });
}



function alerts(contenido, type_class){    
   $('#alert-content').text(contenido);
   $('#alerts').show(1000);
   $('#alerts').removeClass('alert-warning alert-success alert-danger alert-info').addClass(type_class);
}

function hideAlert(){
    $('#alerts').hide(1000);
}

$(document).ready(function() {
    createDataTable("table");
});