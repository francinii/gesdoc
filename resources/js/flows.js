
/** 
 * Clean the inputs
 * 
 */
function clearDescription() {
    $("input[name=CreateDescription]").val("");
    $("input[class=input_check_create]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}
function prueba(){
    alert("holaS");
}
function openCreate(){
    //clearDescription();
    $("#flow-wrapper").hide(500);
    $("#create-wrapper").show(1000);
}
function openTable(){
    $("#create-wrapper").hide(1000);
    $("#flow-wrapper").show(500);
       
}
/**
 * Send an ajax request in order to add a flow 
 * 
 * @param {integer} user - user id
 * 
 */
function ajaxCreate(user){    
    description =  $("input[id=CreateDescription]").val();
    $.ajax({
        url: "flows",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description:   description,
            user_id: user,     
        },

        success: function(result) {
            $("#table").html(result);
            $("#table")
                .DataTable()
                .destroy();
            createDataTable("table");
            $("#create").modal("hide");
            alerts(
                "El flujo " +
                    description +
                    " ha sido creado satisfactoriamente",
                "alert-success"
            );
        },

        error: function(request, status, error) {
            alert(request.responseText);
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
        }
    });
}

/**
 * Open a modal for a edit form
 * 
 * @param {integer} id - flow id
 * @param {string} description  - flow description
 * @param {integer} idUser  - user id 
 * 
 */
function edit(id, description, idUser) {
    $("#flowUsuario option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    $("option[name=flowUsuario" + idUser + "]").prop("selected", true);    
    $("#edit").modal("show");
}

/**
 * Send an ajax request in order to update an specific flow
 * 
 */
function ajaxUpdate() {
    var id = $("input[name=id]").val();
    var description = $("input[id=description]").val();
    var user = $("select[name=flowUsuario] option:selected").val();

    $.ajax({
        url: "flows/{" + id + "}",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            _method: "PATCH",
            id: id,
            description: description,
            user_id: user
        },

        success: function(result) {
            $("#table").html(result);
            $("#table")
                .DataTable()
                .destroy();
            createDataTable("table");
            $("#edit").modal("hide");
            alerts(
                "El flujo " +
                    description +
                    " ha sido actualizado satisfactoriamente",
                "alert-success"
            );
        },

        error: function(request, status, error) {
            alert(request.responseText);
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
        }
    });
}

function changeDepartment(array){
    $(".body_table").empty();
    var id_department = $("select[id=select_document] option:selected").attr('id');
    array.forEach(element => {
        if (id_department == element.department_id)
        {
            $(".body_table").append(
                "<tr>" +               
                    "<td>" +
                    element.username +
                    "</td><td>" +
                    element.name +
                    "</td><td>" +
                    element.email +
                "</td><td><input id ='check"+element.username+"' type ='checkbox'></td></tr>"
            );
        }
   }); 
}


function addStep(){    
    var contenido = $(".step").html();
    //$('.inside_step').attr('id').val('hfdsa');
    contenido = '<div id= "paso'+id+'" class= "container-step">'+ contenido + '</div>';
    $("#steps").append( contenido);
    var elemento = $("#paso"+id).find('.step-description');
    elemento.text('Paso'+ id);
    id += 1;     
}

function openStepEditor(step){

}

/*
function deleteStep(element){
  var elemento = element.closest('div[class^="container-step"]');
  var step = elemento.getAttribute('id');
  $("#"+step).remove();
}*/
//Funciones del flujo

//////////////////// Variables Globales //////////////////
var id = 1; //revisar si se sta usando
var array = Array();
var step = 1;// Necessary for the creation of id in the draggle createStep() method
var divFirst = ""; //usados en el metodo joinStep()
var divSecond = ""; //usados en el metodo joinStep()
//////////////////// Fin Variables Globales //////////////////


new PlainDraggable(document.getElementById('draggable_inicio'), {
    onMove: function() { movimiento() },
    zIndex: false
});
new PlainDraggable(document.getElementById('draggable_final'), {
    onMove: function() { movimiento() },
    zIndex: false
});

function movimiento(){
    array.forEach(element => {
        element.position();
    });
}

function openStep(id){
    alert ('see open Step');
}

function editStep(id){
    alert ('edit Step');
}

function deleteStep(step){
  //  var elemento = element.closest('div[class^="container-step"]');
  var id = step.getAttribute('id');
  var index = 0; 
  var indices = Array();
    array.forEach(line => {              
        if(line.start.getAttribute('id') == id  || line.end.getAttribute('id') == id ){
            line.remove();        
           indices.push(index);
        }
        index+=1;
    }); 
    for (var i = indices.length -1; i >= 0; i--){
        array.splice(indices[i],1);
    }
    $("#"+id).remove();    
}

function createStep(){
    var id = 'draggable' + step;
    var contenido = '<div id = "'+id+'" class="card card_size "> '+
    '<div class="card-step card-header bg-dark">'+
    '<input type="text" placeholder="Descripcion" disabled>  '+             
    '<button type="button" class="btn btn-success" onclick="openStep('+id+')"> '+
    '<i class="far fa-eye"></i> '+
    '</button> '+
    '<button type="button" class="btn btn-info" onclick="editStep('+id+')"> '+
    '<i class="fas fa-edit"></i> '+
    '</button> '+
    '<button type="button" class="btn btn-danger" onclick="deleteStep('+id+')">'+
    '<i class="fa fa-trash"></i> '+
    '</button> '+
    '<button type="button" class="btn btn-warning" onclick="joinStep('+id+')">'+
    '<i class="fas fa-link"></i> '+
    '</button> '+
    '</div>'+
    '</div>' ;
    $("#drag-container").append( contenido);
    step += 1;
    createDraggable(id);
}

function createDraggable(id){
    new PlainDraggable(document.getElementById(id), {
        onMove: function() { movimiento() },
        zIndex: false
    });
}

function joinStep(div){
    var labelName = 'Probando';
    if(divFirst == ""){
        divFirst = div.getAttribute('id');
    } else if(divSecond == "" && divSecond != divFirst ){
        divSecond = div.getAttribute('id');
    }
    if(divFirst != "" && divSecond != "" && divSecond != divFirst ){
        line = new LeaderLine( document.getElementById(divFirst), document.getElementById(divSecond), {
            hide:'true',
            startPlug: 'disc', //Esto hace que el inicio de la linea sea una bolita
        // startLabel: LeaderLine.captionLabel('START', {color: 'blue'}),
            middleLabel: LeaderLine.captionLabel(labelName, {color: 'black'}),
        //  endLabel: LeaderLine.captionLabel('END', {color: 'blue'})
        });
        line.setOptions({startSocket: 'auto', endSocket: 'auto'});
        line.show(); 
        array.push(line);
        reset();
    }
    if(divSecond == divFirst){
        reset();
    }
}

function reset(){
    divFirst = "";
    divSecond = "";
}

function addAction(){

alert('Si funciono!!!!!');
}



