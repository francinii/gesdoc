/**
 * Show the version historial in the wopiHost
 *  
 */
function historial(idDoc){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "historial/{" + idDoc + "}",
      //  url: "documents/historial/{" + idDoc + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idDoc: idDoc,
            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true); 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false); 
            $("#cargandoDiv").css('display', 'none');
            $("#mainContainer").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
            me.data("requestRunning", false); 
            alert(error);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}