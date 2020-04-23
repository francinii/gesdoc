
/** 
 * show the context menu
 * 
 */
var idEdit;
var descriptionEdit;

$("html")
    .on("contextmenu", "td", function (e) {
        var td=e.currentTarget;
        idEdit=td.parentNode.childNodes[1].innerText;
        descriptionEdit=td.parentNode.childNodes[5].innerText;
        var top = e.pageY - 10;
        var left = e.pageX - 90;
        $("#context-menu")
            .css({
                display: "block",
                top: top,
                left: left,
            })
            .addClass("show");
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