//////////////////// Variables Globales //////////////////
var id = 1; //revisar si se sta usando
var array = Array(); //arreglo de objetos LeaderLine
var arrayDraggable = Array();
var step = 1;// Necessary for the creation of id in the draggle createStep() method
var divFirst = ""; //usados en el metodo joinStep()
var divSecond = ""; //usados en el metodo joinStep()
//////////////////// Fin Variables Globales //////////////////




$(document).ready(function (e){
    var n = sessionStorage.length -1;
    while(n>=0) {
        key = sessionStorage.key(n);       
        sessionStorage.removeItem(key);
        n -=1;
                  
    }


    
});
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
// function prueba(){
//     alert("holaS");
// }
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
 * Open a modal for an edit form
 * 
 * @param {integer} id - flow id
 * @param {string} description  - flow description
 * @param {integer} idUser  - user id 
 * 
 */
/*function edit(id, description, idUser) {
    $("#flowUsuario option:selected").each(function() {
        //cada elemento seleccionado
        $(this).prop("selected", false);
    });
    $("input[name=description]").val(description);
    $("input[name=id]").val(id);
    $("option[name=flowUsuario" + idUser + "]").prop("selected", true);    
    $("#edit").modal("show");
} */

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


$('#select_document').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    var evento = e.currentTarget[clickedIndex];
    var name = evento.innerHTML;
   // var department = evento.attributes[0].value;
    var username = evento.attributes[1].value;
    var email = evento.attributes[2].value;
    var seleccionado = evento.selected;
    //var username = $("select[id=select_document] option:selected").attr('id');
    //var email = $("select[id=select_document] option:selected").val();
    //var name = $("select[id=select_document] option:selected").text();
   if(seleccionado){
        appendUserTable(username, name, email);
    }else {
        deleteUserTable(username);
    }
  });

  function appendUserTable(username, name, email){
    $(".body_table").append(
        "<tr id ='tr" + username +  "'><td>" + username +  "</td><td>" + name + "</td><td>" + email +
        "</td><td><button class ='btn btn-danger' onclick= deleteUserTable("+username+") type ='button' ><i class='fas fa-trash-alt'></i></button></td></tr>"
    );
  }

function deleteUserTable(username){
    $('#tr'+username).remove();
    $('#'+username).prop('selected',false);
}

function changeDepartment(array){
    $(".body_table").empty();
    var id_user = $("select[id=select_document] option:selected").attr('id');
    array.forEach(element => {
        if (id_user == element.username)
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

function openStepEditor(step){

}

/*
function deleteStep(element){
  var elemento = element.closest('div[class^="container-step"]');
  var step = elemento.getAttribute('id');
  $("#"+step).remove();
}*/
//Funciones del flujo


// function createStep2(nombre){
   
//     new PlainDraggable(document.getElementById(), {
//         onMove: function() { movimiento() },
//         zIndex: false
//     });
// }



function openStep(step, title){   
    editStep(step, title);
    formDisable(true);
}

function formDisable(property){
    $("#stepId").prop('disabled', property);
    $("#CreateDescription").prop('disabled', property);
    $(".body_table button").prop('disabled', property);
    $("#select_document").prop('disabled', property);    
}

function deleteStep(step){
    //  var elemento = element.closest('div[class^="container-step"]');
    var id = step.getAttribute('id');
    var index = 0; 
    var indices = Array();
      array.forEach(element => {              
          if(element.line.start.getAttribute('id') == id  || element.line.end.getAttribute('id') == id ){
            element.line.remove();        
             indices.push(index);
          }
          index+=1;
      }); 
    for (var i = indices.length -1; i >= 0; i--){
        array.splice(indices[i],1);
    }

    for(let i=0; i<sessionStorage.length; i++) {       
       let key = sessionStorage.key(i);
       item =  JSON.parse(sessionStorage.getItem(key));
       a  =  item.steps;
       b =  item.steps.length;
       for(var j = item.steps.length -1; j >= 0; j--) {        
            if(item.steps[j].begin == id || item.steps[j].end == id ){
                item.steps.splice(j,1);        
                sessionStorage.setItem(item.id, JSON.stringify(item));             
            }        
        }
    }
    $("#"+id).remove();   
      sessionStorage.removeItem(id); 
}
  
function editStep(step, title){
    formDisable(false);
    $(".body_table").empty();
    //var id = step.getAttribute('id');
    var id = step;    
    var elemento = sessionStorage.getItem(id);
    elemento= JSON.parse(elemento);  
    $("#stepId").val(id);    
    $("#CreateDescription").val(elemento.description);    
   var titulo = title + " "+ $("#CreateDescription").val();
    $("#card-title").text(titulo);
        users = elemento.users;
    if(users.length > 0 ){
        users.forEach(element => {
            username =element.username;
            name = element.name;
            email = element.email;
            appendUserTable(username, name, email);
        });
    }
    steps = elemento.steps;
    $("#card").modal("show");
}

function addStep(){    
    idStep =$("#stepId").val();
    var users = [];    
    description = $("#CreateDescription").val();
    $("#tablelist .body_table tr").each(function(){
        user = {
            username:$(this).find("td").eq(0).html(),
            name:$(this).find("td").eq(1).html(),
            email:$(this).find("td").eq(2).html(),
        };
        users.push(user);
    });    
    var step = {
        id : idStep,
        description : description,
        users : users,
        steps : [],
        axisX : '',
        axisY : '',
    }
    saveInStorage(step, idStep);
    $("#card").modal("hide");
    $("#text"+idStep).val(description);    
} 

//sessionStorage.getItem(step);
function saveInStorage(step, stepId){     
    if (typeof(Storage) !== "undefined") {
        (step !=null)?
        sessionStorage.setItem(stepId, JSON.stringify(step)) :
        sessionStorage.setItem(stepId, JSON.stringify(createObjectStep(stepId)));            
    }
}

//Crea un objeto en blanco que es almacenado cuando se crea un step en el local 
//storge
function createObjectStep(stepId) {   
    return step1 = {
        id : stepId,
        description : '',
        users : [],
        steps : [],
        axisX : '',
        axisY : '',
    }
}

function createStartEnd(id, text, class1 ){
   drag = 0;
    arrayDraggable.forEach(element => {
       dragId = element.id;
       if(dragId == id){
            drag = 1;
           
       }
    });   
    if(drag != 1){
        var contenido = 
        '<div id ="'+id+'" class="special_card card">' +
            '<div class="card-step card-header '+class1+'">' +
            '<label>'+text+' </label>' +
            '<button type="button" class="btn btn-warning" onclick="joinStep('+id+')">' +
                '<i class="fas fa-link"></i>' +
            '</button>'+
        '</div>'+
        '</div>';
        addElementToCanvas(id,contenido);
    }
    
}

function createStep(){
    var id = 'draggable' + step;
    var contenido = '<div id = "'+id+'" class="card card_size "> '+
    '<div class="card-step card-header bg-dark">'+
    '<input id ="text'+id+'" type="text" placeholder="Descripcion" disabled>  '+             
    '<button type="button" class="btn btn-success" onclick="openStep(\`'+id+'\`, \`Ver \`)"> '+
    '<i class="far fa-eye"></i> '+
    '</button> '+
    '<button type="button" class="btn btn-info" onclick="editStep(\`'+id+'\`, \`Editar\`)"> '+
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
    step += 1;
    addElementToCanvas(id,contenido);
    editStep(id, 'Crear un nuevo paso');    
}

function movimiento(){
    array.forEach(element => {
        element.line.position();
    });
}

function addElementToCanvas(id,contenido){
    $("#drag-container").append(contenido);
    createDraggable(id);
    saveInStorage(null, id);
}

function createDraggable(id){
     //'draggable_inicio' 'draggable_final'
    drag =new PlainDraggable(document.getElementById(id), {
        onMove: function() { movimiento() },
        zIndex: false
    });
    arrayDraggable.push({id: id, drag: drag}); 
}

function joinStep(div){    
    //Verificar que no se creen lineas que tienen el mismo div de inicio y final  
    var labelName = 'Probando';
    if(divFirst == ""){       
        divFirst = div.getAttribute('id');
        $("#"+divFirst).addClass("card-shadow-info");
    } else if(divSecond == "" && divSecond != divFirst ){        
        divSecond = div.getAttribute('id');
        $("#"+divSecond).addClass("card-shadow-info");
    }
    if(divFirst != "" && divSecond != "" && divSecond != divFirst ){       
        idLine = divFirst+'-'+ divSecond; 
        line = new LeaderLine( document.getElementById(divFirst), document.getElementById(divSecond), {
            hide:'true',
            startPlug: 'disc', //Esto hace que el inicio de la linea sea una bolita
        // startLabel: LeaderLine.captionLabel('START', {color: 'blue'}),           
            startLabel: LeaderLine.captionLabel(idLine, {color: 'red', outlineColor : ''}),
            middleLabel: LeaderLine.captionLabel(labelName, {color: 'black'}),
        //  endLabel: LeaderLine.captionLabel('END', {color: 'blue'})
        });
        line.setOptions({startSocket: 'auto', endSocket: 'auto'});
        line.show(); 
        //Agregar al array de lineas la linea con su respectivo id        
        array.push({id: idLine, line: line});              
        var elemento = sessionStorage.getItem(divFirst);
        elemento= JSON.parse(elemento);  
        elemento.steps.push({begin:divFirst, end: divSecond});
        sessionStorage.setItem(divFirst, JSON.stringify(elemento));
        $("#"+divFirst).removeClass("card-shadow-info");
         $("#"+divSecond).removeClass("card-shadow-info");  
        reset(); 
        //Le da la accion de clicear a los svg text
        $("svg text").css("pointer-events","auto");       
    }
    if(divSecond == divFirst){
        $("#"+divFirst).removeClass("card-shadow-info");
        reset();
    } 
}



$(document).on("click", "svg.leader-line text", function (e) {   
  
   $("#line-modal").modal("show"); 
});  


function reset(){    
    divFirst = "";
    divSecond = "";    
}

 
// $(document).on("click touchend", "svg text", function (e) {
//     alert('Si funciono!!!!!');
// });