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

//////////////////// Variables Globales //////////////////
var id = 1; //revisar si se sta usando
var array = Array(); //arreglo de objetos LeaderLine
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
      sessionStorage.removeItem(id); 
}
  
function editStep(step, title){
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
  //  steps.forEach(element => {
        
   /// });   
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
            sessionStorage.setItem(stepId, JSON.stringify(createObjectStep()) );            
    }
}


//Crea un objeto en blanco que es almacenado cuando se crea un step en el local 
//storge
function createObjectStep(){
    idStep =$("#stepId").val();  
    return step1 = {
        id : idStep,
        description : '',
        users : [],
        steps : [],
        axisX : '',
        axisY : '',
    }
}


function createStep(){
    var id = 'draggable' + step;
    var contenido = '<div id = "'+id+'" class="card card_size "> '+
    '<div class="card-step card-header bg-dark">'+
    '<input id ="text'+id+'" type="text" placeholder="Descripcion" disabled>  '+             
    '<button type="button" class="btn btn-success" onclick="openStep('+id+')"> '+
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
    $("#drag-container").append( contenido);
    step += 1;
    createDraggable(id);
    saveInStorage(null, id);
    editStep(id, 'Crear un nuevo paso');

    
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
        $("svg.leader-line g").click(function(){ myFunction(alert('Hola')); });

      
        var elemento = sessionStorage.getItem(divFirst);
        elemento= JSON.parse(elemento);  
        elemento.steps.push({begin:divFirst, end: divSecond})
        sessionStorage.setItem(divFirst, JSON.stringify(elemento));
        reset(); 

    }
    if(divSecond == divFirst){
        reset();
    }
}


function probando (){
    alert('hola');
}
function reset(){
    divFirst = "";
    divSecond = "";
}

function addAction(){

alert('Si funciono!!!!!');
}




