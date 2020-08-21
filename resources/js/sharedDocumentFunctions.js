/**
 * Show the version historial in the wopiHost
 *  
 */
function historial(idDoc){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "wopiHost/historial/{" + idDoc + "}",
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


/** 
 *  @param {int} code - array of users with ther actions, 
 *  1-vista previa 2-notas 3-descargas 4-historial de acciones
 *  @param {string} version - array of users with ther actions.
 *  @param {string} document - array of users with ther actions.
 *  
 * @return {Array} usersAux - return an array of users with their correspondent actions * 
 */
function openPanel(code, version,document,versionNum){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    $.ajax({
        url: "wopiHost/historial/panel/{" + code + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           code: code,
           version:version,
           versionNum:versionNum,
           document: document,
            
        },
        beforeSend: function (xhr) { 
            me.data("requestRunning", true);
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none');
            $("#contentRight").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
            me.data("requestRunning", false);
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });


}
