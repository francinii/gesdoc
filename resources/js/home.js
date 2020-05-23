/**
* global variable   
*
*/
var idEdit;
var descriptionEdit;
var typeContextMenu;
var currentClassification = null;
var listClassification = [];
var allClassifications
/**
* draw the route follow for the user  
*
*/
function drawRoute() {
    var LastClassificacion = listClassification.slice(-1).pop();

    if (LastClassificacion == null)
        listClassification.push(currentClassification);
    else if (LastClassificacion.id != currentClassification.id)
        listClassification.push(currentClassification);

    $("#tableTitle").empty();

    listClassification.forEach(function (classification, index) {
        $("#tableTitle").append(
            '<button type="button" onclick="BackClassification(' +
                classification.id +
                ')" class="btn btn-light text-left">' +
                classification.description +
                ' <i class="fas fa-angle-right"></i></button>'
        );
    });
}

/**
 * show the context menu
 *
 */
$("html")
    .on("contextmenu", "td", function (e) {
        var td = e.currentTarget;
        typeContextMenu = "";
        idEdit = "";
        descriptionEdit = "";
        if (td.className != "dataTables_empty") {
            typeContextMenu =
                td.parentNode.childNodes[1].childNodes[1].innerText;
            idEdit = td.parentNode.childNodes[9].innerText;
            descriptionEdit = td.parentNode.childNodes[3].innerText;
        }
        var top = e.pageY - 10;
        var left = e.pageX - 90;

        $("#context-menu")
            .css({
                display: "block",
                top: top,
                left: left,
            })
            .addClass("show");
        if (typeContextMenu == "classification") {
            $("#editClassificationContext").show();
            $("#deleteContext").show();
            $("#shareContext").show();
        } else if (td.className == "dataTables_empty") {
            $("#editClassificationContext").hide();
            $("#deleteContext").hide();
            $("#shareContext").hide();
        } else {
            $("#editClassificationContext").hide();
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
    var me = $(this);

    if (me.data("requestRunning")) {
        return;
    }
    me.data("requestRunning", true);

    if (validaCreate()) {
        var description = $("input[name=nameCreate]").val();

        $.ajax({
            url: "home",
            method: "POST",

            data: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                _token: $("input[name=_token]").val(),
                currentClassification: currentClassification.id,
                description: description,
            },
            success: function (result) {
                $("#table").DataTable().destroy();
                $("#divTable").html(result);

                createDataTable("table");
                $("#create").modal("hide");
                alerts(
                    "La clasificacion " +
                        description +
                        " ha sido agregado satisfactoriamente",
                    "alert-success"
                );
                me.data("requestRunning", false);
            },
            error: function (request, status, error) {
                alerts("Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                me.data("requestRunning", false);
            },
        });
    }
}

/**
 * Open a modal to edit a classification
 *
 * 
 */
function edit() {
    $("select option:selected").each(function () {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("#listEdit").empty();
    $("input[id=idEdit]").val(idEdit);
    $("input[name=descriptionEdit]").removeClass("is-invalid");
    $("input[name=descriptionEdit]").val(descriptionEdit);
    

    drawMoveEdit(currentClassification);

    $("#edit").modal("show");
}
/**
 * 
 * @param {array} classifications to drawn in move
 */

function drawMoveEdit(classifications){
    $("input[id=editClassification]").val(classifications.id);
    $("label[id=editLableClassification]").text(classifications.description);
    
    $("#listEdit").empty();
    classifications.classifications.forEach(function (classification, index) {
        $("#listEdit").append(
            '<li id="listEdit-' + classification.id +'" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">' +
                classification.description +
                '<span class="btn badge badge-secondary badge-pill"  onclick="editEnterClassification(' +
                classification.id +
                ')"><i class="fas fa-long-arrow-alt-right"></i></span>' +
                "</li>"
        );
    });
}

/**
 * modal to edit, open a classification
 *
 * @param {Integer} id of the classification opend
 * 
 */

function editEnterClassification(id) {
    alert("open"+id);
}

/**
 * modal to edit, back to the parent classification
 *@param {Object} allClassifications list of all classification
 */
function editBackClassification() {
    var openedClassification=editFindParentClassification(allClassifications['classification'], $("input[id=editClassification]").val());
    if(openedClassification!=true && openedClassification!=null){
        drawMoveEdit(openedClassification);
    }
}
/**
 * modal to edit, find the parent of a classification
 * @param {Object} Classification list of all classification
 * @param {Integer} id of the classification
 */
function editFindParentClassification(Classification,id){
    var openedClassification
    if(Classification.id==id) 
        return true;

    for (let index = 0; index <  Classification.classifications.length; index++) {
        if(Classification.classifications[index].id==id)
        return Classification;            
    }
    for (let index = 0; index <  Classification.classifications.length; index++) {
        return editFindParentClassification(Classification.classifications[index],id);        
    }
}
/**
 * modal to edit, find the classification
 * @param {Object} allClassification list of all classification
 * @param {Integer} id of the classification
 */
function editFindClassification(allClassification,id){
    if(parent){
 
    }
 
 }



/**
 * open a classification
 *
 * @param {Integer} id of the classification opend
 * 
 */
function openClassification(id) {
    var me = $(this);

    if (me.data("requestRunning")) {
        return;
    }
    me.data("requestRunning", true);

    $.ajax({
        url: "home/" + id,
        method: "get",

        data: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            _token: $("input[name=_token]").val(),
            id: id,
        },
        success: function (result) {
            $("#table").DataTable().destroy();
            $("#divTable").html(result);

            createDataTable("table");
            $("#create").modal("hide");
            me.data("requestRunning", false);
        },
        error: function (request, status, error) {
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
            alert(request.responseText);
            me.data("requestRunning", false);
        },
    });
}

/**
* back to a classification opened before
* @param {Integer} id of the classification opend
*/
function BackClassification(id) {
    var LastClassificacion = listClassification.slice(-1).pop();

    if (LastClassificacion.id != id) {
        LastClassificacion = listClassification.pop();
        while (LastClassificacion.id != id) {
            LastClassificacion = listClassification.pop();
        }
        openClassification(id);
    }
}
