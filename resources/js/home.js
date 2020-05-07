
/** 
 * show the context menu
 * 
 */
var idEdit;
var descriptionEdit;
var type
var currentClassification;
$("html")
    .on("contextmenu", "td", function (e) {
        var td=e.currentTarget;
        type= td.parentNode.childNodes[1].childNodes[1].innerText;
        idEdit=td.parentNode.childNodes[9].innerText;
        descriptionEdit=td.parentNode.childNodes[3].innerText;
        var top = e.pageY - 10;
        var left = e.pageX - 90;

        $("#context-menu")
            .css({
                display: "block",
                top: top,
                left: left,
            }).addClass("show");
        if(type!="classification"){
            $("#editClassification").hide();
        }else{
            $("#editClassification").show();
        }
        return false; //blocks default Webbrowser right click menu
    })
    .on("click", function () {
        $("#context-menu").removeClass("show").hide();
    });

$("#context-menu button").on("click", function () {
    $(this).parent().removeClass("show").hide();
});


/** 
 * Clean the create form
 * 
 */
function clearCreate() {
    $("input[name=nameCreate]").val("");
}


/** 
 * Validate the inputs in the create form
 * 
 */

function validaCreate() {
    var validado = true;
    if ($("input[name=nameCreate]").val() == "") {
        $("input[name=nameCreate]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=nameCreate]").removeClass("is-invalid");
      
    } 
    return validado;
}


/**
 * Send an ajax request in order to add a classification
 *  
 */
function ajaxCreate() {
    if (validaCreate()) {       
        var description = $("input[name=nameCreate]").val();       

        $.ajax({
            url: "home",
            method: "POST",

            data: {
                _token: $("input[name=_token]").val(),
                currentClassification:currentClassification,
                description: description,            
            },
            success: function(result) {
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");                
                $("#create").modal("hide");
                alerts("La clasificacion "+description+" ha sido agregado satisfactoriamente", "alert-success");
            },
            error: function(request, status, error) {
                
                    alerts("Ha ocurrido un error inesperado.", "alert-danger");
                    alert(request.responseText);
                
            }
        });
    }
}



/**
 * Open a modal to edit a role
 * 
 * @param {integer} idEdit - department id, global variable
 * @param {string} descriptionEdit  - department name, global variable
 *    
 */
function edit() {
  $("select option:selected").each(function() {
      //cada elemento seleccionado
      $(this).prop("selected", false);
  });
  $("input[id=idEdit]").val(idEdit);
  $("input[name=descriptionEdit]").removeClass("is-invalid");
  $("input[name=descriptionEdit]").val(descriptionEdit);

  $("#edit").modal("show");
}