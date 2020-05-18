//////////////////// Variables Globales //////////////////
var id = 1; //revisar si se sta usando
var array = Array(); //arreglo de objetos LeaderLine
var arrayDraggable = Array(); //arreglo de objetos Draggable
var step = 1;// Necessary for the creation of id in the draggle createStep() method
var divFirst = ""; //usados en el metodo joinStep() 
var divSecond = ""; //usados en el metodo joinStep()
//////////////////// Fin Variables Globales //////////////////


$(document).ready(function (e){  
   // draggable =  $("#drag-container");
   // draggable.autoScroll = true;
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

function openCreate(){
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
    description =  $("input[id=flowName]").val();
    data = "";
    datos = [];
    for (var i = 0; i < sessionStorage.length; i++){
       data = sessionStorage.getItem(sessionStorage.key('draggable'+i));
       datos[i] = JSON.parse(data);
        // Do something with localStorage.getItem(localStorage.key(i));
    }  

    $.ajax({
        url: "flows",
        method: "POST",
        data: {
            _token: $("input[name=_token]").val(),
            description:   description,
            data: datos,   
            username: user 
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
            username: user
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
    select_user(e, clickedIndex , 'body_table');
});

$('#select_user_line').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    select_user(e, clickedIndex, 'body_table_line');
});

function select_user(e, clickedIndex, tableId){
    var evento = e.currentTarget[clickedIndex];
    var name = evento.innerHTML;
    var username = evento.attributes[1].value;
    var email = evento.attributes[2].value;
    var seleccionado = evento.selected;

    if(seleccionado){
        appendUserTable(username, name, email, tableId);
    }else {
        deleteUserTable(tableId,username);
    }
}

function appendUserTable(username, name, email, tableId){
    $("."+tableId).append(
        "<tr id ='" +  tableId + username +  "'><td>" + username +  "</td><td>" + name + "</td><td>" + email +
        "</td><td><button class ='btn btn-danger' onclick= deleteUserTable('"+ tableId +"','"+username+"') type ='button' ><i class='fas fa-trash-alt'></i></button></td></tr>"
    );
  }


function openPermissions(actions){
    $(".body_table_line").empty();
    var users = [];
   // id = $(this).closest("#stepId").val();
    cadena = "";
    
   // tabla = $(element).closest(".body_table");
    $('.body_table tr').each(function() {
        user = {
            username:$(this).find("td").eq(0).html(),
            name:$(this).find("td").eq(1).html(),
        };
        users.push(user);
    });    
    //elemento = sessionStorage.getItem(id);
   // elemento = JSON.parse(elemento);
  //  users = elemento.users;  

    users.forEach(user => {
       cadena += '<tr><td id = "'+user.username+'">'+user.name+'</td>';
        actions.forEach(action => {
            idAction = action.id;
            cadena += '<td ><input type ="checkbox" class="form-check-input " id = "'+idAction+'" ></td>';
        });
        cadena += '</tr>';
    });
    $(".body_table_line").append(cadena);
    $("#card-title").val('Agregar permisos a usuarios');
    $("#modal-body-step").hide(500);
    $("#modal-body-step-back").show(500);
} 


function savePermissions(){
    stepId =$("#stepId").val();

    usernames ="";
    actionsByUser = [];
    var cont = 0; 
    $('#tableLine .body_table_line tr').each(function () {  
        username  = $(this).find("td").eq(0).attr('id');
      //  $(this).each(function(){});
        $.each($("input:checked", this), function(){
            actionsByUser.push($(this).attr('id'));
        });
        item = sessionStorage.getItem(stepId);
        item2 = JSON.parse(item);
        item2.actions.push({username: username, actions: actionsByUser});
        sessionStorage.setItem(stepId, JSON.stringify(item2));
        actionsByUser = [];   
    });
    

}

function openStepEdition(){
  

    $("#modal-body-step-back").hide(500);
    $("#modal-body-step").show(500);

    $("#card-title").val('Edición del departamento');
    //Cambia el contenido del body del modal 
}  

function deleteUserTable(tableId, username){
    $('#'+tableId+username).remove();
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
    $("#modal-body-step-back").hide(500);
    $("#modal-body-step").show(500);   
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
        $('#select_document').find('option').prop('selected',false);
    if(users.length > 0 ){
        users.forEach(element => {
            username =element.username;
            name = element.name;
            email = element.email;
            appendUserTable(username, name, email, 'body_table');
            /////////////////////
            $('#select_document #'+username).prop('selected',true);
        });
    }
    steps = elemento.steps;
    $("#card").modal("show");
}

function openStep(step, title){   
    editStep(step, title);
    formDisable(true);
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

    var elemento = sessionStorage.getItem(idStep);
    elemento = JSON.parse(elemento);
    var steps = (elemento != null )? elemento.steps : [];

    var step =  createObjectStep(idStep,description,users,steps,[],'','') ;
    saveInStorage(step, idStep);
    $("#card").modal("hide");
    $("#text"+idStep).val(description);    
} 

//sessionStorage.getItem(step);
function saveInStorage(step, stepId){     
    if (typeof(Storage) !== "undefined") {
        (step !=null)?
        sessionStorage.setItem(stepId, JSON.stringify(step)) :
        sessionStorage.setItem(stepId, JSON.stringify(createObjectStep(stepId,'',[],[],[],'','')));            
    }
}

//Crea un objeto en blanco que es almacenado cuando se crea un step en el local 
//storge
function createObjectStep(stepId,description,users,steps,actions,axisX,axisY) {   
    return step1 = {
        id : stepId,
        description : description,
        users : users,
        steps : steps,
        actions:actions,
        axisX : axisX,
        axisY : axisY,
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
        saveInStorage(null, id);
    }    
}

function createStepCard(id){
    return '<div id = "'+id+'" class="card card_size "> '+
    '<div class="card-step card-header bg-dark justify-content-center">'+
    '<div class = "w-100" ><input id ="text'+id+'" type="text" placeholder="Descripcion" disabled> </div> '+             
    '<div class = "btn-group btn-group-justify w-100"><button type="button" class="btn btn-success" onclick="openStep(\`'+id+'\`, \`Ver \`)"> '+
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
    '</button></div> '+
    '</div>'+
    '</div>' ; 
}

function createStep(){
    var id = 'draggable' + step;
    contenido = createStepCard(id);
    step += 1;
    addElementToCanvas(id,contenido);
    saveInStorage(null, id);
    editStep(id, 'Crear un nuevo paso');    
}

function movimiento(){
    array.forEach(element => {
        element.line.position();
    });
}


//****** */
function addElementToCanvas(id,contenido){
    $("#drag-container").append(contenido);
    createDraggable(id);   
}

function createDraggable(id){
     //'draggable_inicio' 'draggable_final'
    drag =new PlainDraggable(document.getElementById(id), {
        onMove: function() { movimiento() },
        zIndex: false,      
    });
    
    arrayDraggable.push({id: id, drag: drag}); 
}

function joinStep(div){    
    //Verificar que no se creen lineas que tienen el mismo div de inicio y final  
    var labelName = 'Acción siguiente';
    if(divFirst == ""){       
        divFirst = div.getAttribute('id');
        $("#"+divFirst).addClass("card-shadow-info");
    } else if(divSecond == "" && divSecond != divFirst ){        
        divSecond = div.getAttribute('id');
        $("#"+divSecond).addClass("card-shadow-info");
    }
    if(divFirst != "" && divSecond != "" && divSecond != divFirst ){       
        idLine = divFirst+'-'+ divSecond; 
        begin = document.getElementById(divFirst);
        end =document.getElementById(divSecond);        

        createLine(begin, end, idLine, labelName);  

        var identificador = divFirst+"-"+divSecond;
        storageLine(identificador, divFirst, divSecond,'', []);        
        
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

/*
 * Guarda un paso( accion )en el storage
*/
function storageLine(identificador, divFirst, divSecond,action, usersLine){
    var elemento = sessionStorage.getItem(divFirst);      
    elemento= JSON.parse(elemento);  
    elemento.steps.push({id: identificador,begin:divFirst, end: divSecond, action: action, usersLine: usersLine});
    sessionStorage.setItem(divFirst, JSON.stringify(elemento));
}


function createLine(begin, end, idLine, labelName){
    line = new LeaderLine( begin , end , {
        hide:'true',
        startPlug: 'disc', //Esto hace que el inicio de la linea sea una bolita
        // startLabel: LeaderLine.captionLabel('START', {color: 'blue'}),           
        startLabel: LeaderLine.captionLabel(idLine, {color: 'none', outlineColor : ''}),
        middleLabel: LeaderLine.captionLabel(labelName, {color: 'black'}),
        //  endLabel: LeaderLine.captionLabel('END', {color: 'blue'})
    });
        line.setOptions({startSocket: 'auto', endSocket: 'auto'});
        line.show(); 
        array.push({id: idLine, line: line});  
}

var lineaSeleccionada = null;
var elementoSeleccionada = null;
$(document).on("click", "svg.leader-line text", function (e) {  
    $(".body_table_line").empty();
    elementoSeleccionada = e.currentTarget;          
    textoId = elementoSeleccionada.previousElementSibling.innerHTML;     
    var arr =textoId.split('-');
    lineaSeleccionada = arr;
    //lineaSeleccionada  = (arr.length > 0 )? arr[0]: '' ; 
    elemento  = (arr.length > 0 )? sessionStorage.getItem(arr[0]): null ;
    elemento = JSON.parse(elemento);
    steps = elemento.steps;
    if(steps.length > 0 ){
        steps.forEach(element => {
            if(element.usersLine.length > 0 ){
                element.usersLine.forEach(element => {
                    username =element.username;
                    name = element.name;
                    email = element.email;
                    appendUserTable(username, name, email, 'body_table_line');
                });
            }
        });
    }  
   $("#line-modal").modal("show"); 
});  

function saveAction(){
   users = [];
    if(elementoSeleccionada != null)  {   
    e = elementoSeleccionada; 
    textoId = e.previousElementSibling.innerHTML;     
    var arr =textoId.split('-');
    lineBegin  = (arr.length > 0 )? arr[0]: '' ; 
    elemento  = (arr.length > 0 )? sessionStorage.getItem(arr[0]): null ;
       
    var select_action =  $("select[id=select_action] option:selected").text();
    var id_select_action =  $("select[id=select_action] option:selected").val();
    e.innerHTML = select_action;
    var elemento = sessionStorage.getItem(lineBegin);      
        elemento= JSON.parse(elemento);
        arreglo = elemento.steps;
        arreglo.forEach(ele => {
            if( ele.id == textoId ){
                $("#tableLine .body_table_line tr").each(function(){
                    user = {
                        username:$(this).find("td").eq(0).html(),
                        name:$(this).find("td").eq(1).html(),
                        email:$(this).find("td").eq(2).html(),
                    };
                    users.push(user);
                });  
                
                ele.usersLine = users;
                ele.action = id_select_action;
                //element.steps.push({id: identificador,begin:begin, end: end, action: select_action, usersLine: [] });
                sessionStorage.setItem(lineBegin, JSON.stringify(elemento));
                $('#line-modal').modal('hide');
            }
        });
       
    }
   
}

function deleteAction(){ 
    $("#line-modal").modal("hide"); 
    arr =lineaSeleccionada;
    begin   = (arr.length > 0 )? arr[0]: '' ; 
    end  = (arr.length > 0 )? arr[1]: '' ; 
    var index = 0; 
    var indices = Array();

    /*Busca la linea a remover y la elimina del canvas  */
      array.forEach(element => {              
          if(element.line.start.getAttribute('id') == begin && element.line.end.getAttribute('id') == end ){
            element.line.remove();        
             indices.push(index);
          }
          index+=1;
      });
      /*Elimina del arreglo "array" la linea removida   del elemento */
    for (var i = indices.length -1; i >= 0; i--){
        array.splice(indices[i],1);
    }
    /* Elimina del storage la linea removida  */
    for(let i=0; i<sessionStorage.length; i++) {       
       let key = sessionStorage.key(i);
       item =  JSON.parse(sessionStorage.getItem(key));
       for(var j = item.steps.length -1; j >= 0; j--) {        
            if(item.steps[j].begin == begin && item.steps[j].end == end ){
                item.steps.splice(j,1);        
                sessionStorage.setItem(item.id, JSON.stringify(item));             
            }        
        }
    }
}

function reset(){    
    divFirst = "";
    divSecond = "";    
}


function editFlow(){
    //obtener datos de la base de datos
    //setearlo en el storage
    // 
    //Creamos el html del card
    
    contenido = createStepCard(id);
    //agregamos primero todos los drag al canvas    
    addElementToCanvas(id,contenido);
    //De una agregamos los drag al storage
    saveInStorage(null, id);

    //Luego creamos las lineas  con el inicio, final, idLine ( divFirst+'-'+ divSecond; ) y nombre
    //Guarda las lineas en un array llamado array (Global)
    createLine(begin, end, idLine, labelName);

    //Guarda la linea en el storage
    storageLine(identificador, divFirst, divSecond,action, usersLine)


}