
/**
 * This function is in charge of create the data table and give
 * them the all necesary attirbutes.
 * 
 * @param {string} table - id name of the  table
 *  
 */
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


/**
 * This function shows a modal in order to confirm if you 
 * really want to delete the element.
 * 
 * @param {integer} id -id of the element for delete
 * @param {string} url1 - url of the deleted element
 * @param {string} table - table to repaint
 * @param {string} messasge -Message that you want to show
 *  
 */
function confirmDelete(id, url1,table,message){
    $( "#mensajeConfirmar" ).html( "<p>"+message+"</p>" );  
    $("#confirmarButton").attr("onClick","ajaxDelete('"+id+"','"+url1+"','"+table+"')");
    $("#confirmar").modal("show");
}


/**
 * Send an ajax request in order to delete an element 
 *  
 */
function ajaxDelete(id, url1,table){
    var me = $(this);

    if (me.data("requestRunning"))
        return;
    me.data("requestRunning", true);

    var array = table.split('-');
    table=array[0];
    if(array.length>1){
        divTable=array[1];
    }else{
        divTable=table
    }
    $.ajax({
        url: url1 + "/" + id,
        method: "POST",

        data: {
            _token: $("input[name=_token]").val(),
            _method:'DELETE',
            id:id,
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {  
            me.data("requestRunning", false);
            $("#"+table).DataTable().destroy();         
            $("#"+divTable).html(result);            
            createDataTable(table);
            $("#confirmar").modal("hide");
            alerts('alerts', 'alert-content',"Elemento eliminado correctamente.", "alert-success");
            
            $("#cargandoDiv").css('display', 'none')
        },
        error: function (request, status, error) {  
            me.data("requestRunning", false);    
            $("#confirmar").modal("hide");                  
            alerts('alerts', 'alert-content',"Ha ocurrido un error al intentar eliminar el elemento.", "alert-danger");
            alert(request.responseText);
            $("#cargandoDiv").css('display', 'none')
        }
    });
}


/**
 * Show a div when an event is actived.  (For example when you 
 * add, delete, or update data).
 *  
 */
function alerts(idAlert, idContent, contenido, type_class){    
   $('#'+idContent).text(contenido);
   $('#'+idAlert).show(1000);
   $('#'+idAlert).removeClass('alert-warning alert-success alert-danger alert-info').addClass(type_class);
}

/**
 * Hide an alert div when you click on the x button.
 *  
 */
function hideAlert(id){
    
    $('#'+id).hide(1000);
}


/**
 * Create a dataTable
 *  
 */
$(document).ready(function() {
    createDataTable("table");
});