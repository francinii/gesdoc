

var select = document.getElementById('selectDoc');
select.addEventListener('change',
  function(){
    var selectedOption = this.options[select.selectedIndex];
   // alert(selectedOption.value + ': ' + selectedOption.text);
    var idFlow = selectedOption.value;

    $.ajax({
        url: "documentFlow/{" + idFlow + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idFlow: idFlow,
            
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#table").html(result);
            $("#table").DataTable().destroy();
            
            createDataTable("table");            
           
        },

        error: function(request, status, error) {
           
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
  
});



function historial(idDoc){

    $.ajax({
        url: "documentFlow/historial/{" + idDoc + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idDoc: idDoc,
            
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#content").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}




/**
 *   
 * 
 *  @param {int} code - array of users with ther actions, 
 *  1-vista previa 2-notas 3-descargas 4-historial de acciones
 *  @param {string} version - array of users with ther actions.
 *  @param {string} document - array of users with ther actions.
 *  
 * @return {Array} usersAux - return an array of users with their correspondent actions * 
 */
function openPanel(code, version,document,versionNum){
    $.ajax({
        url: "documentFlow/historial/panel/{" + code + "}",
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
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#contentRight").html(result);
           // $("#table").DataTable().destroy();
            
           // createDataTable("table");            
           
        },

        error: function(request, status, error) {
          
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });


}