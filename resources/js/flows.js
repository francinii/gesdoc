/**
 * Global variables.
 *
 * @global {integer} id - Global id //revisar si se sta usando
 * @global {string} array  - LeaderLine objects' array
 * @global {integer} step  - Global count for each new draggable
 * @global {array} arrayDraggable - Draggable objects' array
 * @global {array} divFirst  - Use it in the joinStep() function  
 * @global {array} divSecond  - Use it in the joinStep() function 
 *
 */
var id = 1; 
var arrayLines = Array(); 
var arrayDraggable = Array(); 
var stepGlobal = 1; //global count for each step
var divFirst = ""; 
var divSecond = ""; 
var idFlowForUpdate = "";  // For update the same flow dont create each tine
var globalMode = 0;
var editionMode = 0;
const DRAGGABLE_FINAL = "draggable_final";
const DRAGGABLE_INICIO = "draggable_inicio";

/**
 * Ready function actived when the flows.js is called.
 * This function delete all the elements in the sessionsStorage
 *
 *
 */
$(document).ready(function (e){  
   // draggable =  $("#drag-container");
   // draggable.autoScroll = true;
   clearStorage();
});


//window.addEventListener('load', function() {
    //'use strict';  
    //movementLine();
  
  //});


/** 
 * Clear all the items inside the storage
 * 
 */
function clearStorage(){
    var n = sessionStorage.length -1;
    while(n>=0) {
        key = sessionStorage.key(n);       
        sessionStorage.removeItem(key);
        n -=1;                  
    } 
}

/** 
 * Clean the nodes childs
 * 
 */
function clearchildNodes(idDiv){  
    while (idDiv.firstChild) {
        idDiv.removeChild(idDiv.firstChild);
    }
}

/** 
 * Clean the arrows inside the canvas
 * 
 */
function clearArrow(classDiv){  
    $('.'+classDiv).remove();
    $('.leader-line-defs').remove();    
}

/** 
 * Clean the inputs inside each form
 * 
 */
function clearDescription() {
    $("input[name=CreateDescription]").val("");
    $("input[class=input_check_create]:checked").each(function() {
        //cada elemento seleccionado
        $(this).prop("checked", false);
    });
}


/** 
 * Show the screen that allow you to create a flow
 *  @param editMode 1- active flow (edit mode has to be inactive )   0- inactive flow (edit mode has to be active ) 
 */
function openCreate(editMode){
    editionMode = editMode; //Set the general edition mode create view or edit  
    $("#flow-wrapper").hide();
    $("#create-wrapper").show();
    if(editMode == 1){
        $("#button-actions").remove();
        $("#btnSavePermissions").remove();
        $("#hideModalCardSave").remove();
        $("#line-modal .modal-footer").remove();  
        $("#select_action").attr('disabled',true);               
        $('#flowName').attr('disabled',true);
    }

    
}


/** 
 * 
 * List the flows that you are  owner
 * 
 */
function openTable(){
    window.location="flows";
   // clearAll();   
    //Global variable
   // idFlowForUpdate = "";
   // $("#flowName").val("");
    //$("#create-wrapper").hide();
   // $("#flow-wrapper").show();
  // $("#confirmar").modal("hide");       
}

/** 
 * 
 * Update the coordenates of each draggable
 * 
 */
function updateCoordenates(){

    for (var i = 0; i < sessionStorage.length; i++){
        key = sessionStorage.key(i);
        data = sessionStorage.getItem(key);
         dato = JSON.parse(data);
        var stepId = dato.id;
        var description = dato.description;
        users = dato.users;
        steps = dato.steps;
        var coordenates = getCoordinates(stepId);

        var axisX = coordenates.length >0? coordenates[0]:'0';
        var axisY = coordenates.length >1? coordenates[1]:'0'; 
        object= createObjectStep(stepId,description,users,steps,axisX,axisY);
        sessionStorage.setItem(stepId,JSON.stringify( object ));
    }        
}


/**  
 * Get the coordenates in axis X and axis.
 * 
 * @param {string} id - Id of the draggable
 * @return {Array} coordenates - return an array with the x and y axis.
 * 
 */
function getCoordinates(id){
    var coordenates = [];
    var elemento = document.getElementById(id);
     transformStyle = elemento.style.transform;
     var parOrdenado = transformStyle.replace(/[\A-Za-z()]/g, '');
     coordenates = parOrdenado.split(',');
     return coordenates;// return an array
}

function confirm(message){
    $( "#mensajeConfirmar" ).html( "<p>"+message+"</p>" );  
    $("#confirmarButton").attr("onClick","openTable()");
    $("#confirmar").modal("show");
}


/**
 * Send an ajax request in order to add a flow 
 * 
 * @param {string} user - user id
 * 
 */
function ajaxCall(user){  
    var me = $(this);
 if (me.data("requestRunning"))
    return;
    
   // updateCoordenates();  
    description =  $("input[id=flowName]").val();
    data = "";
    datos = [];
    updateCoordenates();
    valid = validateFlow();
    var id = idFlowForUpdate;
    var message = ''; 

    if(valid==0){ 
        for (var i = 0; i <= sessionStorage.length; i++){
            key = sessionStorage.key(i);
            data = sessionStorage.getItem(key);
            datos.push(JSON.parse(data));
        }
        if(id != ''){
            url = "flows/" + id + "";
            method = "PATCH";
            message= 'Elemento actualizado satisfactoriamente.';
        }       
        else {
            url = "flows";
            method = "";
            message= 'Elemento agregado satisfactoriamente.';
        }  
        
        $.ajax({
            url: url,
            method: "POST",
            data: {
                _token: $("input[name=_token]").val(),
                description:   description,
                _method: method,
                data: datos,   
                username: user,
                id:id,
            },
            beforeSend: function (xhr) { 
                me.data("requestRunning", true);
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) { 
                me.data("requestRunning", false); 
                $("#cargandoDiv").css('display', 'none')
               openTable();        
               alerta('Proceso exitoso', message,false);
               // alerts('alerts', 'alert-content',  "El flujo " +  description + " ha sido creado satisfactoriamente",
               //"alert-success" );
                $("#table").html(result);
                $("#table").DataTable().destroy();
                createDataTable("table");
                $("#create").modal("hide");
                idFlowForUpdate='';
                
             
            },
            error: function(request, status, error) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alert(request.responseText);
                alerta("Ha ocurrido un error inesperado.", "alert-danger");
                openTable();
                
            }
        }); 
    }
}


/**
 * 
 * Send an ajax request in order to update an specific flow
 * 
 */
function ajaxUpdate() {
    var me = $(this);
    if (me.data("requestRunning"))
       return;
    description =  $("input[id=flowName]").val();
    data = "";
    datos = [];
    valid = validateFlow();

    if(valid){       
        for (var i = 0; i <= sessionStorage.length; i++){
            key = sessionStorage.key(i);
            data = sessionStorage.getItem(key);
            datos.push(JSON.parse(data));
        }
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
            beforeSend: function (xhr) { 
                 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) { 
                $("#cargandoDiv").css('display', 'none')  
                me.data("requestRunning", false);  
                $("#table").html(result);
                $("#table")
                    .DataTable()
                    .destroy();
                createDataTable("table");
                $("#edit").modal("hide");
                alerts('alerts', 'alert-content',
                    "El flujo " +
                        description +
                        " ha sido actualizado satisfactoriamente",
                    "alert-success"
                );
                
            },
            error: function(request, status, error) {
                me.data("requestRunning", false);
                $("#cargandoDiv").css('display', 'none')
                alert(request.responseText);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                
            }   
        });
    }
}


/**
 * 
 * Edit an specific resource. 
 * @param {integer} idFlow - flow's id 
 * @param {string} flowName - flow's name  
 * @param {int} editMode - 0 flow is inactive (EditMode) 1- flow is active you can edit it.
 * 
 */
function ajaxEdit(idFlow,flowName, editMode) {   
    editionMode =  editMode;
    var me = $(this);
 if (me.data("requestRunning"))
    return;
    
    idFlowForUpdate = idFlow;  //Global variable idFlowForUpdate
       $.ajax({
        url: "flows/{" + idFlow + "}",
        method: "GET",
        dataType: 'JSON',
        data: {
            _token: $("input[name=_token]").val(),
            _method: "PATCH",
            id: idFlow,
        },
        beforeSend: function(){
            me.data("requestRunning", true);  
            $("#cargandoDiv").css('display', 'block')
        },       
        success: function (response){
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none')
           hideAlert('alerts');
            $("input[id=flowName]").val(flowName);
            editFlow(response,editMode);
           
            
           
        },
        done: function(response) {
            
        },

        error: function(request, status, error) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none')
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            
        }
    });

}

/**
 * 
 * Event that is actived when an user select an element.
 * 
 */
$('#select_document').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    select_user(e, clickedIndex , 'body_table');
});

/**
 * 
 * Event that is actived when an user select an element.
 * 
 */
$('#select_user_line').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
    select_user(e, clickedIndex, 'body_table_line');
});

/**
 * Add to an specific table the selected users in a combobox.
 * @param {event} e - trigger  the event.
 * @param {integer} clickedIndex - selected item.
 * @param {integer} tableId - id of the table to add an user.
 * 
 */
function select_user(e, clickedIndex, tableId){
    var evento = e.currentTarget[clickedIndex];
    if(evento==null) return;
    var name = evento.innerHTML;
    var username = evento.attributes[1].value;
    var email = evento.attributes[2].value;
    var seleccionado = evento.selected;

    if(seleccionado){
        appendUserTable(username, name, email, tableId);
    }else {
        deleteUserTable(tableId,username,'select_document');
    }
}


/**
 * Add to the UserTable a new User with this information: username, name, email.
 * @param {string} username.
 * @param {string} name - name of the selected user.
 * @param {string} email - email of the selected user.
 * @param {string} tableId - id of the table for update.
 * 
 */
function appendUserTable(username, name, email, tableId){
    select_document = "select_document";
    $("."+tableId).append(                                     
        "<tr id ='" +  tableId + username +  "'><td>" + username +  "</td><td>" + name + "</td><td>" + email +
        "</td><td><button class ='btn btn-danger delete' onclick=deleteUserTable('"+tableId +"','"+username+"','"+select_document+"') type ='button' ><i class='fas fa-trash-alt'></i></button></td></tr>"
    );
}


/**
 * Open a modal with a list of permissions. In this modal you can edit 
 * the permission of each user that you add in the edit modal. 
 * @param {array} actions - List of actions that an user can execute in each step
 * 
 */
function openPermissions(actions){
    addStep(); // Save in the local storage

    $(".body_table_line").empty();
    var users = [];
    var cadena = "";
    stepId =$("#stepId").val();
    elemento = sessionStorage.getItem(stepId);
    elemento = JSON.parse(elemento);
    users = elemento.users;  
    chequeado = "";
    habilitado = "";
    users.forEach(user => {
       cadena += '<tr><input type="hidden" id = "input'+user.username+'" value ="'+user.email+'"><td id = "'+user.username+'">'+user.name+'</td>';

       actions = actions.filter(act =>act.type == 0 || act.type == 1 );
       actions.forEach(action => {
            idAction = "'" + action.id+"'";
            acciones =  user.actions;
        if(acciones !== undefined  || acciones > 0){
                chequeado = acciones.includes(idAction)? 'checked': "";
                habilitado = (globalMode == 1) ? 'disabled': "";
            }           
            cadena += '<td ><input type ="checkbox" class="form-check-input " id = "'+idAction+'" '+chequeado+' '+habilitado+' ></td>';
        });
        cadena += '</tr>';
    });
    
    $(".body_table_line").append(cadena);
    $("#card-title").val('Agregar permisos a usuarios');
    $("#modal-body-step").hide(500);
    $("#modal-body-step-back").show(500);
} 


/**
 * Save the permissions that an user has in one step. 
 * 
 */
function savePermissions(){
    var stepId =$("#stepId").val();
    usernames ="";
    actionsByUser = [];
    users = [];
    var cont = 0; 
    $('#tableLine .body_table_line tr').each(function () {  
        username  = $(this).find("td").eq(0).attr('id');
        name  = $(this).find("td").eq(0).text();
        email  = $("#input"+username).val();
        //  $(this).each(function(){});
        $.each($("input:checked", this), function(){
            actionsByUser.push($(this).attr('id'));
        });
        user = {
            username: username,
            name: name,
            email: email,
            actions: actionsByUser,
        }
        users.push(user); 
        actionsByUser = [];   
    });

    item = sessionStorage.getItem(stepId);
        item = JSON.parse(item);
        description = item.description;
        steps = item.steps;
        actions = item.actions;
        axisX = item.axisX;
        axisY = item.axisY;         
        item = createObjectStep(stepId, description, users, steps, axisX, axisY);
        sessionStorage.setItem(stepId, JSON.stringify(item));

        alerts('alertPermission', 'alert-permission-content',
        "Los permisos han sido actualizados satisfactoriamente",
        "alert-success" );
}

/**
 * Open the modal that show the edit step part. 
 * 
 */
function openStepEdition(){  
    if(editionMode == 0){
        savePermissions();
    }
    
    $("#modal-body-step-back").hide(500);
    $("#modal-body-step").show(500);
    $("#card-title").val('Edición del departamento');
    hideAlert('alertPermission');
    
    //Cambia el contenido del body del modal 
}  


/**
 * Delete an user inside the tableUser showed in the editModal step 
 * @param {integer} tableId - id of the table to update
 * @param {string} username - id of the user that is going to be deleted
 * 
 */
function deleteUserTable(tableId, username, selectP){
    $('#'+tableId+username).remove();
    $('#'+selectP +' #'+username).prop('selected',false);
    $('#'+selectP +' #'+username).attr('selected',false);
    $('#'+selectP).selectpicker('refresh');
    //$('#select_document').selectpicker('refresh');
}


/**
 * Able or disable a form. If the view is in edit mode the 
 * property is going to be false and if it is view mode the
 * property is going to be true.
 *  
 * @param {bool} property - Define if the form is able or disaable 
 * 
 */
function formDisable(property){
    $("#stepId").prop('disabled', property);
    $("#CreateDescription").prop('disabled', property);
    $(".body_table button.delete").prop('disabled', property);
    $("#select_document").prop('disabled', property);      
}


/**
 * Delete an specific step. Is called when the user select the 
 * delete button in a single step.( The step that is in the canvas).
 *  
 * @param {DOM element} step - step to be deleted.
 * 
 */
function deleteStep(step){
    var id = step.getAttribute('id');
    var index = 0; 
    var indices = Array();
        //Global array of lines
        arrayLines.forEach(element => {              
            if(element.line.start.getAttribute('id') == id  || element.line.end.getAttribute('id') == id ){
                element.line.remove();        
                indices.push(index);
            }
            index+=1;
        }); 
    for (var i = indices.length -1; i >= 0; i--){
        //Global arrayLines of lines
        arrayLines.splice(indices[i],1);
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

  
/**
 * Shows a modal to edit a single step.
 *  
 * @param {DOM} step - id ofthe step to be edited
 * @param {string} title - title of the modal
 * 
 */

function editStep(step, title, mode) {
     $('#select_document').find('option').prop('selected',false);
     //$('#select_document').find('option').attr('selected',false);
     $('#select_document').selectpicker('refresh');
    //0 edit mode 1 create mode
    globalMode = mode; 
   
    $("#modal-body-step-back").hide(500);
    $("#modal-body-step").show(500);  
    $(".body_table").empty();
    var id = step;    
    var elemento = sessionStorage.getItem(id);
    elemento= JSON.parse(elemento);  
    $("#stepId").val(id);    
    $("#CreateDescription").val(elemento.description);    
   var titulo = title + " "+ $("#CreateDescription").val();

    $("#card-title").text(titulo);
        users = elemento.users;
       

    if(typeof users !== 'undefined'){
        users.forEach(element => {
            username =element.username;
            name = element.name;
            email = element.email;
            appendUserTable(username, name, email, 'body_table');
           // $('#select_document'+username).prop('selected',true);
        //  $('#'+username).attr('selected',true);
          $('#'+username).prop('selected',true);
        });
    }
   // steps = elemento.steps;
    globalMode == 1 ? formDisable(true):formDisable(false);
    $('#select_document').selectpicker('refresh');
    $("#card").modal("show");

}

/**
 * Open the edit modal. 
 * 
 * @param {DOM} step - id of the step to be edited
 * @param {string} title - title of the modal
 * @param {int} mode - define if the modal is in view or
 *  in edit mode (1 view mode 0 edit mode)
 * 
 */
function openStep(step, title,mode){     
    editStep(step, title, mode);
   // formDisable(true);
}


/**
 * Add a step to the sessionStorage  
 * 
 */
function addStep(){  
    if(validateFields()){  
        idStep = $("#stepId").val();
        var users = [];    
        var actions = [];
        description = $("#CreateDescription").val();
        var elemento = sessionStorage.getItem(idStep);    
        elemento = JSON.parse(elemento);    
        $("#tablelist .body_table tr").each(function(){
        username = $(this).find("td").eq(0).html();
        usuarios = elemento.users;

        //verify if this user exist in the session storage 
        //and if that exist adding their actions to the
        // new user.
        usuarios.forEach(element => {
            if(username == element['username'] ){
                actions = element.actions;
            }
        }); 

        // build a new user
            user = {
                username:username,
                name:$(this).find("td").eq(1).html(),
                email:$(this).find("td").eq(2).html(),
                actions: actions,
            };
            users.push(user);
            actions = [];
        });        
        var steps = (elemento != null )? elemento.steps : [];
        var step =  createObjectStep(idStep,description,users,steps,'','') ;
        saveInStorage(step, idStep);  
          $("#text"+idStep).val(description);    
    }    
} 

/**
 * Add a step to the sessionStorage  and close the modal
 * 
 */
function hideModalCardSave(){
    if(editionMode == 0){
        savePermissions();
    }
    addStep();
    if(validateFields()){
        $("#card").modal("hide");
    }
    
}

/**
 * Save an step in the storage
 * 
 * @param {string} stepId - id of the step to be saved
 * @param {Object} step - step object to be saved
 */
function saveInStorage(step, stepId){     
    if (typeof(Storage) !== "undefined") {
        (step !=null)?
        sessionStorage.setItem(stepId, JSON.stringify(step)) :
        sessionStorage.setItem(stepId, JSON.stringify(createObjectStep(stepId,'',[],[],'','')));            
    }
}

/**
 * Create an Step Object
 * 
 * @param {string} stepId - id of the step 
 * @param {string} description - description of the step
 * @param {array} users - users with permissions in this step
 * @param {array} steps - preview and next step and their action
 * @param {string} axisX - position in x of the step
 * @param {string} axisY - position in y of the step
 */
function createObjectStep(stepId,description,users,steps,axisX,axisY) {   
    return step1 = {
        id : stepId,
        description : description,
        users : users,
        steps : steps,
        axisX : axisX,
        axisY : axisY,
    }
}


/**
 * Create an Step Object
 * 
 * @param {integer} id - Add an special step to the canvas (It is used
 *  for the beggining and end card inside the canvas).
 * @param {string} text - Description of the step
 * @param {string} class1 - focus in the div that is selected 
 */
function createStartEnd(id, text, class1 ){
   drag = 0;
    arrayDraggable.forEach(element => {
       dragId = element.id;
       var desc = (dragId == DRAGGABLE_INICIO)?'Solo puede haber un elemento inicial':'Solo puede haber un elemento final';

       if(dragId == id){
           drag = 1;
           alerta('Elemento existente',desc,false);
       }
            
    });  
    var  buttonLink = '';
    if(editionMode == 0){
       buttonLink =  '<button type="button" class="btn btn-warning" onclick="joinStep('+id+')">' +
    '<i class="fas fa-link"></i></button>'; 
    }
    
    if(drag != 1){
        var contenido = 
        '<div id ="'+id+'" class="special_card card">' +
            '<div class="card-step card-header '+class1+'">' +
            '<label>'+text+' </label>' + buttonLink + '</div>'+'</div>';
        addElementToCanvas(id,contenido);
        saveInStorage(null, id);
    }    
}

/**
 * Create an Card Step Object Node
 * 
 * @param {integer} id - Of the step (draggable#)
 * 
 */
function createStepCard(id, description){
    var  buttonLink = '';
    if(editionMode == 0){
        buttonLink = '<button type="button" class="btn btn-success" title = "Editar paso" onclick="editStep(\`'+id+'\`, \`Editar\`, 0)"> '+
        '<i class="fas fa-edit"></i> '+
        '</button> '+
        '<button type="button" title = "Eliminar paso" class="btn btn-danger" onclick="deleteStep('+id+')">'+
        '<i class="fa fa-trash"></i> '+
        '</button> '+
        '<button type="button" class="btn btn-warning" title = "Unir pasos" onclick="joinStep('+id+')">'+
        '<i class="fas fa-link"></i> '+
        '</button>';
    }

    return '<div id = "'+id+'" class="card card_size "> '+
    '<div class="card-step card-header bg-dark justify-content-center">'+
    '<div class = "w-100" ><input id ="text'+id+'" class="textdraggable" type="text" value = "'+description+'" placeholder="Descripcion" disabled>  </div> '+             
    '<div title = "Ver paso"  class = "btn-group btn-group-justify w-100"><button type="button" class="btn btn-info" onclick="openStep(\`'+id+'\`, \`Ver \`, 1)"> '+
    '<i class="far fa-eye"></i> '+
    '</button> '+ buttonLink +
    '</div> '+
    '</div>'+
    '</div>' ; 
}

/**
 * Includes an step card to the Canvas and save it in 
 * the session Storage. 
 * 
 */
function createStep(){
    //step global count for each step
    var id = 'draggable' + stepGlobal; // id of the new step
    contenido = createStepCard(id, ""); // create a card step node
    stepGlobal += 1;  
    addElementToCanvas(id,contenido); // add the card step to the canvas
    saveInStorage(null, id); // save an empty step in the storage with the id 
    editStep(id, 'Crear un nuevo paso',0);    //Change the label text of the modal 
}


/**
 * Define the position of each line inside the array of lines
 * 
 */
function movimiento(){
    //Array of Lines Objects GLobal
    arrayLines.forEach(element => { 
        element.line.position();
        ///Nuevo
        //containerDrag = document.getElementById("drag-container-wrapper").target;
        //containerDrag.addEventListener('scroll', function() {
        //    element.line.position();
       // });
    });
}


function movementLine(){
     // var containerDrag = document.getElementById("drag-container-scrollable");

      //  containerDrag.addEventListener('scroll', AnimEvent.add(function() {          
      //      line.position();      
      //  }), false);
   
    var containerDrag = document.getElementById("drag-container-scrollable");
    containerDrag.addEventListener('scroll', AnimEvent.add(function() {     
    arrayLines.forEach(element => {             
            element.line.position(); 
    });   
    }), false);
      
}


/**
 *  Add the card step to the canvas.
 * @param {integer} id - id Of the step (draggable#)
 * @param {string} contenido -html contend to be add it to the canvas.
 */
function addElementToCanvas(id,contenido){
    $("#drag-container").append(contenido);
    createDraggable(id);   
}


/**
 *  Create a Draggable Object of the card in the canvas.
 * Then, it adds it to the Draggable array.
 * (arrayDraggable is a Global variable).
 * 
 *  @param {integer} id - id Of the step (draggable#)
 */
function createDraggable(id){
    drag =new PlainDraggable(document.getElementById(id), {
        onMove: function() { movimiento() },
        zIndex: false,    
        autoScroll:true,    
        
    }); 

    //drag.autoScroll = true;

    //var doc = document.getElementById("drag-container");
    //doc.scrollTop = doc.scrollHeight;

    //drag.containment = {width: '10000', height: '10000'};  
   //drag.autoScroll = true;
    
    arrayDraggable.push({id: id, drag: drag}); 
   
}

/**
 *  It joins to different card steps.
 *  Then draw a line between each step.
 * 
 *  @param {html} div - div html object
 */
function joinStep(div){  
    var bandera =  false;  
    var action = '-1';
    //Verificar que no se creen lineas que tienen el mismo div de inicio y final  
    var labelName = divFirst == DRAGGABLE_INICIO? 'Inicio': 'Acción siguiente';
    var action = divFirst == DRAGGABLE_INICIO? '-2': action;
   // action =  divFirst == DRAGGABLE_INICIO? ''
    if(divFirst == ""){   
        //Firts div to join    
        divFirst = div.getAttribute('id');
        $("#"+divFirst).addClass("card-shadow-info");

    } else if(divSecond == "" && divSecond != divFirst ){    
        //Second div to join      
        divSecond = div.getAttribute('id');        
        $("#"+divSecond).addClass("card-shadow-info");
    }
    if(divFirst != "" && divSecond != "" && divSecond != divFirst ){       
        idLine = divFirst+'-'+ divSecond; 
        begin = document.getElementById(divFirst);
        end =document.getElementById(divSecond);    
        
        if(validateBeginEnd(divFirst,divSecond)){
        //Create a line between each card step.
         bandera =   createLine(begin, end, idLine, labelName);  
        //line's id
            var identificador = divFirst+"-"+divSecond;
        //Storage the line to the  sessionStorage
            if(bandera)
                storageLine(identificador, divFirst, divSecond,action, []);  
        }               
        //Remove the focus class
        $("#"+divFirst).removeClass("card-shadow-info");
         $("#"+divSecond).removeClass("card-shadow-info");  
        reset(); 
        //Give the action click to the svg text
      //  $("svg text").css("pointer-events","auto");     
    }
    if(divSecond == divFirst ){ 
        if(divFirst != ''){
            $("#"+divFirst).removeClass("card-shadow-info");
            reset();  
        }       
                         
    } 
}

/**
 * Save a Line to the session Storage
 * @param {integer} identificador - id of the line
 * @param {string} divFirst - first div to join
 * @param {string} divSecond - second div to join
 * @param {string} action - action to be execute for the user to go from 
 * the first step to the second step.
 * @param {string} usersLine - Users who can execute the action
 *
 */
function storageLine(identificador, divFirst, divSecond,action, usersLine){
    var elemento = sessionStorage.getItem(divFirst);      
    elemento= JSON.parse(elemento);  
    elemento.steps.push({id: identificador,begin:divFirst, end: divSecond, action: action, usersLine: usersLine});
    sessionStorage.setItem(divFirst, JSON.stringify(elemento));
}


/**
 * Draw a line between two card steps in the canvas.
 * @param {string} begin - id of the first card step 
 * @param {string} end - id of the second card step
 * @param {string} idLine - second div to join
 * @param {string} labelName - name of the action
 * @param {string} usersLine - Users who can execute the action
 *
 */
function createLine(begin, end, idLine, labelName){
var bandera = false;
//Global array of lines 
if(arrayLines)
    arrayLines.forEach(element => {
         arr = element['id'].split('-');  
        var line = idLine.split('-');      
        if( arr[0]== line[0] && line[0] == DRAGGABLE_INICIO)
            bandera =true;        
    });
    if(!bandera){
        line = new LeaderLine( begin , end , {
            hide:'true',
            startPlug: 'disc', //Esto hace que el inicio de la linea sea una bolita
            // startLabel: LeaderLine.captionLabel('START', {color: 'blue'}),           
            startLabel: LeaderLine.captionLabel(idLine, {color: 'none', outlineColor : ''}),
            middleLabel: LeaderLine.captionLabel(labelName, {color: 'black'}),
            //  endLabel: LeaderLine.captionLabel('END', {color: 'blue'})    
              
        });   
        line.positionByWindowResize =false;
        movementLine();
       // var containerDrag = document.getElementById("drag-container-scrollable");

      //  containerDrag.addEventListener('scroll', AnimEvent.add(function() {          
      //      line.position();      
      //  }), false);
     
              
       
      //  line.positionByWindowResize = false,
        line.setOptions({startSocket: 'auto', endSocket: 'auto', positionByWindowResize: true});
        line.show(); 
        arrayLines.push({id: idLine, line: line});  
         //Give the action click to the svg text
          ///Nuevo

        $("svg text").css("pointer-events","auto");   
        return true;
    }else {
        alerta('Alerta', 'El inicio no puede tener más de dos líneas',false);
        return false;
    }    
}

var lineaSeleccionada = null;
var elementoSeleccionada = null;

/**
 * Draw a line between two card steps in the canvas.
 *
 */
$(document).on("click", "svg.leader-line text", function (e) {  
    $(".body_table_line").empty();
    elementoSeleccionada = e.currentTarget;          
    textoId = elementoSeleccionada.previousElementSibling.innerHTML;     
    var arr =textoId.split('-');
    lineaSeleccionada = arr;
    //lineaSeleccionada  = (arr.length > 0 )? arr[0]: '' ; 
    elemento  = (arr.length > 0 )? sessionStorage.getItem(arr[0]): null ;
    elemento = JSON.parse(elemento);

    if(arr[0] == DRAGGABLE_INICIO){
         $("#div-selector-action").css('display','none');
         $(".modal-footer #EditSubmit").css('display','none');
    } else {
        $("#div-selector-action").css('display','block');
        $(".modal-footer #EditSubmit").css('display','block');
    } 
   
   $("#line-modal").modal("show"); 
});  

/**
 *Save the action between two step cards to the sessionStorage
 *
 */
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

/**
 *Delete the action between two steps
 * Then, update the steps in the sessionStorage
 */
function deleteAction(){ 
    $("#line-modal").modal("hide"); 
    arr =lineaSeleccionada;
    begin   = (arr.length > 0 )? arr[0]: '' ; 
    end  = (arr.length > 0 )? arr[1]: '' ; 
    var index = 0; 
    var indices = Array();

    /*Busca la linea a remover y la elimina del canvas  */
    //Global array
      arrayLines.forEach(element => {              
          if(element.line.start.getAttribute('id') == begin && element.line.end.getAttribute('id') == end ){
            element.line.remove();        
             indices.push(index);
          }
          index+=1;
      });
      /*Elimina del arreglo "arrayLines" la linea removida   del elemento */
    for (var i = indices.length -1; i >= 0; i--){
        arrayLines.splice(indices[i],1);
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

/**
 *  Reset the Global Variables divFirst and divSecond
 */
function reset(){    
    divFirst = "";
    divSecond = "";    
}



/*****Metodos para las validaciones de campos, contenido y alertas. ****/

/**
 *  Validate the createDescription field is not empty
 */
function validateFields(description, idField, idFieldError, message){
    $("#"+idFieldError).remove();
    isEmpty= description != '' ? true: false;
    if(!isEmpty){
        $("#"+idField).after('<p id = "'+idFieldError+'">'+message+'</p>');
        $("#"+idField).addClass("card-shadow-info");
        $("#"+idFieldError).css('color', 'red');
        return false;    
    }
    return true;
}


/**
 *  Delete the class of a field with id: "CreateDescription" that is invalid
 */
$( "#CreateDescription" ).focus(function() {
    $("#CreateDescription").removeClass("card-shadow-info");
    $("#errLabel").remove();
   
  });


/**
 *  Delete the class of a field with the  id: "flowName" that is invalid
 */
  $( "#flowName" ).focus(function() {
    $("#flowName").removeClass("card-shadow-info");
    $("#errFlow").remove();
   
  });
 

/**
 * 
 * This function validates if a line is correctly define. (Ex: Elements that can't be join)
 * @param {integer} begin - flow's id 
 * @param {string} end - flow's name  
 * 
 */
  function validateBeginEnd(begin,end){
      var title = "Alerta";
      var description = "";
      var bandera = true;
   if(begin == DRAGGABLE_FINAL){
        description = 'El elemento final no puede asociarse a otro elemento';       
        bandera = false;
    }
    else if(end == DRAGGABLE_INICIO){
        description ='El elemento inicial no puede asociarse a otro elemento' ;         
        bandera = false;
    }
    else if(begin == DRAGGABLE_INICIO && end == DRAGGABLE_FINAL){
        description ='No es posible conectar estos dos elementos' ; 
        bandera  = false;
    }
    alerta(title, description,bandera);
    return bandera;
  }


  /**
 * 
 * Shows a modal with an alert (Error, Succed, etc).
 * 
 * @param {string} title - Modal´s title
 * @param {string} description - Modal´s description
 * @param {boolean} bandera -shows or hdie the modal 
 * 
 */
  function alerta(title, description,bandera){
    $('#alertModalTitle').text(title);
    $('#alertModalDescription').text(description);
    bandera == false ? $("#alertModal").modal('show'): "";
  }
  
/**
 * 
 * Validate if an action from the same div is duplicated.
 * 
 * @param {string} item - Object in the storage
 * 
 */
  function validateRepeatAction(item){
    var cont = 0;    
    var steps = item.steps;
    var arrayAux =steps;  
    var bandera = -1;  
    steps.forEach(element => {
        if(element['action'] == '-1')
            bandera = 2;
            arrayAux = arrayAux.splice(1);
            arrayAux.forEach(element2 => { 
                element['action'] == element2['action']? cont++: cont;           
            });
        });
        if (bandera == 2) 
            return 2; // There are lines without valid actions
        else 
            return cont >= 1? 1:0; //If is more equal than one means that there are some lines with the same action from the same step
}



// Por hacer aun antes de seguir con lo del historial
function validateIsAssociated(item){

    if(item['id'] != DRAGGABLE_INICIO && item['id'] != DRAGGABLE_FINAL){
    var isFinal = false;
    var isBeggining = false;    
    var line = [];

    keys = Object.keys(sessionStorage);           
        for (let index = 0; index < keys.length; index++) {
            drag = sessionStorage.getItem(keys[index]);
            drag = JSON.parse(drag);
            drag.steps.forEach(element2 => { 
                line = element2['id'].split('-');
                    if(line[0] == item['id'])
                        isBeggining = true;
                    else if(line[1] ==item['id'])
                        isFinal = true;
                          
            });           
        }
        if(!isBeggining || !isFinal)
                    return false; // El step no tiene un elemento hacia donde ir 
    }
    return true;
}

function validateBeginAssociated(){
    var keys = Object.keys(sessionStorage); 
    var validBegin = false;
    var validEnd = false;
    for (let index = 0; index < keys.length; index++) {
        item = sessionStorage.getItem(keys[index]);
        item = JSON.parse(item);
    
        item.steps.forEach(element2 => { 
                line = element2['id'].split('-');
                    if(line[0] ==DRAGGABLE_INICIO)
                        validBegin =  true;                      
                    if(line[1] == DRAGGABLE_FINAL)
                        validEnd =  true;        
                });  
                    
    } 
    if(validBegin && validEnd)
        return true;
return false;
}

/**
 * 
 * Validate if a flow is correct and send the request
 * 
 * @param {string} item - Object in the storage
 * 
 */
function validateFlow(){
   // stepDescription = $("#CreateDescription").val();
   var flowName = $("#flowName").val();
    validFlow =validateFields(flowName, 'flowName', 'errFlow', 'Por favor, rellene este campo.' )
   var result = 0; //Todo esta bien
   var resultIsAssociated = 0;
   if(!validateBeginAssociated()){
    description = 'El elemento inicial y final DEBEN estar asociados a almenos un elemento.';
    alerta('Error',description, false);
    result = 8;
}
    else if(validFlow){
            keys = Object.keys(sessionStorage);           
            hayInicio = false;
            hayFinal = false;
            validField = true; // Valid until the opposite is proved
            for (let index = 0; index < keys.length; index++) {
                item = sessionStorage.getItem(keys[index]);
                item = JSON.parse(item);

                // Verify if the step has a description (except the beggining step and ending step)
                if(  item['id'] != DRAGGABLE_INICIO &&  item['id'] != DRAGGABLE_FINAL ){
                    $(".textdraggable").each(function(){
                        validField =  ( $(this).val() !== '' )? true:false;
                    });                   
                }            

                // Verify if a begin and end step exist in the flow          
                hayInicio = item['id'] == DRAGGABLE_INICIO? true: hayInicio;
                hayFinal = item['id'] == DRAGGABLE_FINAL?  true: hayFinal;

                // Validate if the actions are not repeat it in each step. 
                result = validateRepeatAction(item);
               
                if(result == 1){
                    description = 'El elemento ' +item['description']+ ' está asociado con las mismas acciones a varios pasos siguientes. Asegurese que cada línea que sale de un mismo paso tiene diferente acción.';
                    alerta('Error',description, false);
                    //return result;
                    break;
                } else if(result == 2){
                    description = 'El elemento ' +item['description']+ 'Tiene líneas sin acciones específicas, asegurese que todas las conexiones posean una acción que pueda ejecutarse.';
                    alerta('Error',description, false);                    
                    //return result;
                    break;
                }
                // Validate if the fields are valid
                else if (!validField) {
                    description = 'Hay elementos que no poseen una descripcion. Asegúrese que cada paso tiene una descripción no vacía.';
                    alerta('Error',description, false);                  
                   // return 3;
                   result = 3;
                   break;
                }else {
                     resultIsAssociated = validateIsAssociated(item);
                     if(!resultIsAssociated){
                        description = 'El flujo no es correcto. Hay elemento que no poseen relación con otros elementos del flujo. Compruebe que todos los elementos están relacionados con un elemento siguiente.';
                        alerta('Error',description, false);
                        result = 7;       
                        break;                                     
                    }   
                }
            }
            if(!hayInicio && result == 0){
                description = 'El flujo no tiene un elemento inicial. Asegurese de agregar un paso inicial.';
                alerta('Error',description, false);
                result = 6;                
            } else if(!hayFinal  && result == 0){
                description = 'El flujo no tiene un elemento final. Asegurese de agregar un paso final.';
                alerta('Error',description, false);
                result = 4;                
            }  
    }else {
        description = 'El flujo no posee una descripción. Asegúrese de que el nombre del flujo no esté vacío.';
        alerta('Error',description, false);
        result = 5;
    }
    

return result;  
}



/**
 * 
 * Map an user and return an Array of users' object.
 * 
 * @param {Array} actionStepUser - array of users with ther actions.
 * @param {string} id - Id of an specific step.
 * 
 * @return {Array} usersAux - return an array of users with their correspondent actions * 
 */
function mapUser(actionStepUser, id){
    var usersAux = [];
    var users =[];
    var actions = [];
    var item = '';
    if(typeof actionStepUser !== 'undefined'){ 
        //Filter the actionsStepUser by id of the step
        actionsUsers= actionStepUser.filter(ast =>ast.step_id == id );
        actionsUsers.forEach(element => {
            if(!users.includes(element['username'])){
                users.push(element['username']);
                //Filter the actionsUser by username
                us = actionsUsers.filter(user => user.username == element['username'] );
                    //Save each action of the user in the actions array
                    us.forEach(element => {
                        item = element;
                        actions.push("'" + element['action_id']+"'");
                    }),
                    //Build a user object
                    user = {
                        username:item.username,
                        name: item.name,
                        email: item.email,
                        actions: actions,
                    }
                    //Save the user in the array
                    usersAux.push(user);
                    //Reset the actions array
                    actions =[];
             }           
        });
        //Reset the actions array
        users = [];
    }
    return usersAux;
}

/**
 * 
 * Map a step and return an Array of steps' object.
 * 
 * @param {Array} stepStep - array of steps.
 * @param {string} id - Id of an specific step.
 * 
 * @return {Array} aux - return an array of steps (lines). 
 */
function mapStep(stepStep,id){ 
     aux = [];
    
    if(typeof stepStep !== 'undefined'){  
        //Filter the stepStep by id of the step
        stepStep =  stepStep.filter(step1 =>step1.prev_step_id == id );  
        stepStep.forEach(element => {           
        id = element.prev_step_id + "-"+ element.next_step_id;
         //Create a step'object (Here the steps correspond to a line).
            stepObject = {
                begin:element.prev_step_id,
                end: element.next_step_id,
                action: element.id_action,
                description:element.description,
                id: id,
            };
         //Add a step object in the aux's array.
        aux.push(stepObject);
        begin = document.getElementById(stepObject.begin);
        end =document.getElementById(stepObject.end);  
         //Create the line between two draggable divs
        
        bandera = createLine(begin, end, stepObject.id, stepObject.description);
        if(bandera)  //Save the line in the storage
            storageLine(stepObject.id, stepObject.begin, stepObject.end,element.id_action, []);
        });
  }
   return aux;
}


/**
 * 
 *  Update a specific flow
 * 
 */
function editFlow(data, editMode){

    /**
     *  Clean all the storage, array and draggablearray
     */    
    clearAll();    
    
    /**
     * Get the database data and set at storage
     */
    var flow = data.flow;
    var description = flow.description;
    var steps = flow.steps;
    var stepStep = data.step_step; //lines
    var actionStepUser = data.action_step_user;
    var users1 = [];

     /**
     * Steps building
     */    
    if(typeof steps !== 'undefined'){
        steps.forEach(element => {
            var id = element['id'];
            axisX =  element['axisX'];
            axisY =  element['axisY'];
            description = element['description'];
            if(element['id'] == DRAGGABLE_FINAL)
                contenido = createStartEnd(id, 'Final', 'bg-danger');
            else if(element['id'] == DRAGGABLE_INICIO)
                contenido =  createStartEnd(id, 'Inicio', 'bg-success');
            else {
                //Splice del id draggable# (to get the number of the draggable)
                stepCount = id.slice(9);
                stepCount = parseInt(stepCount);
                if(stepGlobal <= stepCount){
                    stepGlobal =stepCount + 1; //necessary to know the last step and continues counting
                }     
                 /**
                 * create a card step node and Add the card step to the canvas
                 */         
                contenido = createStepCard(id,description);   
                addElementToCanvas(id,contenido); 
            }
                
            /**
             * Add the draggables to the storage
             */ 
            users1 =  mapUser(actionStepUser,element['id']);
            object = createObjectStep(id,description,users1,[],axisX,axisY);
            saveInStorage(object, id); 
            traslateDrag(id, axisX,axisY);        
            //storageLine(id, divFirst, divSecond,action, []);  
        });

        /** 
         * Then create the lines with the beginning and ending included ( divFirst+'-'+ divSecond; ) and the name
         * And Save the lines in the SessionStorage
         */   
        openCreate(editMode);   
        steps.forEach(element => {
          
            var id = element['id']; 
            itemStorage = sessionStorage.getItem(id);
            itemStorage=JSON.parse(itemStorage);
            axisX =  element['axisX'];
            axisY =  element['axisY'];  
            description = element['description']; 
           
            steps2 =  mapStep(stepStep, id);
            users2 = itemStorage.users; //get the users storaged
            object = createObjectStep(id,description,users2,steps2,axisX,axisY);
            
            saveInStorage(object, id);
           // traslateDrag(id, axisX,axisY);  
        });     
       
    }
}
/**
 * 
 * Reset All of Global  variables and the SessionStorage.
 * Also reset the draggable divs and lines in the DOM
 * 
 */
function clearAll(){
    //Global array
    arrayLines = Array(); 
    arrayDraggable = Array(); 
    clearStorage();
    idDiv = document.getElementById("drag-container");
    clearchildNodes(idDiv);
    clearArrow('leader-line');
}

/**
 * Set the coordenates of each drag in the canvas
 * 
 * @param {string} id - Draggable´s id.
 * @param {string} x - Axis X.
 * @param {string} y - Axis Y.
 */
function traslateDrag(id, x,y){
    $('#'+id).css({
        "-webkit-transform":"translate("+x+"px,"+y+"px)",
        "-ms-transform":"translate("+x+"px,"+y+"px)",
        "transform":"translate("+x+"px,"+y+"px)",
    })
}
/**
 * Active or desactive the flow
 * @param e event 
 * @param id  id of the element to be edit
 * @param flow flow's name  
 */
actFlow ="";
function activeFlowModal(e, id, flow){
    actFlow = e;
    var select = document.getElementById(id);
    var selectedOption = actFlow.options[select.selectedIndex];
    var active = selectedOption.value;
    var message = (active == 0)?
    'Si el flujo tiene documentos adjuntos, estos serán eliminados del flujo ¿Desea continuar?':
    '¿Desea activar el flujo? El flujo solo puede editarse cuando está inactivo. Sí este se encuentra activo, no podrá ser modificado.';
    $( "#mensajeConfirmar" ).html( "<p>"+message+"</p>" );  
    $("#confirmarButton").attr("onClick","activeFlow("+active+","+flow+")");
    $("#hideConfirmButton").attr("onClick","hideConfirmButton("+active+","+flow+","+id+")");
    $("#confirmar").modal("show");
}

function hideConfirmButton(active, flow, select){

    if( active == 0 ){
        $("#active"+flow).attr('selected', true);
        $("#active"+flow).prop('selected', 'selected');
       $("#inactive"+flow).removeAttr("selected");
            
    }
    else {
        $("#active"+flow).removeAttr('selected');
        $("#inactive"+flow).attr('selected', true);
        $("#inactive"+flow).prop('selected', 'selected');
 
    }
    $("#confirmar").modal("hide");
}

function activeFlow(active, idFlow){
   // $("#selectFlow").val();

   idFlow;
    $.ajax({
        url: "flow/active/{" + idFlow + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idFlow: idFlow,
           active: active,
            
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            $("#table").html(result);
            $("#table").DataTable().destroy();
            alerts('alerts', 'alert-content',"La actividad del flujo fue modificada correctamente.", "alert-success");
            createDataTable("table");   
            $("#confirmar").modal("hide");         
           
        },

        error: function(request, status, error) {
           
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });
}


function permissionModal(idFlow, actions){
    var actions2 = [];
    actions2 = actions;
    var identifier = $('#idPermissionModal').val();
    
    idFlow;
    $.ajax({
        url: "flow/permission/{" + idFlow + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idFlow: idFlow, 
           identifier: identifier,             
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
            
            $("#permissionModal").html(result);
            $('#selectUserPermission').selectpicker();
            $('#selectUserPermission').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                select_permission(e, clickedIndex , 'body_table_permission',actions2);
            });
            $("#permissionModalS").modal('show');         
        },

        error: function(request, status, error) {           
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none')
        }
    });

}


function permissionModalTable(idFlow, actions2){
    var identifier = $('#idPermissionModal').val();
    
    $.ajax({
        url: "flow/permissionTable/{" + idFlow + "}",
        method: "GET",
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idFlow: idFlow, 
           identifier: identifier,             
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
           // $('#selectUserPermission').remove();

            $("#permissionModalS #permtable").html(result);
            $('#selectUserPermission').selectpicker();
            $('#selectUserPermission').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                select_permission(e, clickedIndex , 'body_table_permission',actions2);
            }); 
                            
        },

        error: function(request, status, error) {           
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none');

          
        }
    });

}


function select_permission(e, clickedIndex, tableId,actions2){
    var evento = e.currentTarget[clickedIndex];
    if(evento==null) return;
    var name = evento.innerHTML;
    var username = evento.attributes[0].value;
   // var email = evento.attributes[2].value;
    var seleccionado = evento.selected;

    if(seleccionado){
        appendPermissionTable(username, name,tableId,actions2);
    }else {
        deleteUserTable(tableId,username,'selectUserPermission');
    }
}



function appendPermissionTable(username, name, tableId,actions2){
    var select_permission1 = 'selectUserPermission';
    var cadena = '';
    var count = 0;
    actions2.forEach(act => {
        //Ternary operator
        
   
      cadena += '<td ><input id = "'+act.id+'" type ="checkbox" class="form-check-input"></td>'
      count++;
     
        
    });

    $("."+tableId).append(
        "<tr id ='" +  tableId + username +  "'><td id = '"+ username +"' >" + username +  "</td><td>" + name + "</td>" +
        cadena+"<td><button class ='btn btn-danger delete' onclick= deleteUserTable('"+ tableId +"','"+username+"','"+select_permission1+"') type ='button' ><i class='fas fa-trash-alt'></i></button></td></tr>"
    );
}



function savePermissionsModal(idFlow, saveMode){
    actionStepUser = [];
    identifier = $('#idPermissionModal').val();
    $('#tablePermission #body_table_permission tr').each(function () {  
        username  = $(this).find("td").eq(0).attr('id');
        actSteUs = [];
        actSteUs.push(username);
        $.each($("input:checked", this), function(){
            actSteUs.push($(this).attr('id'));
        }); 
        actionStepUser.push(actSteUs);        
    });

    $.ajax({
        url: "flow/savePermissionsModal/{" + idFlow + "}",
        method: "GET",        
        headers: {
           
          },
        data: {
           "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
           _token: $("input[name=_token]").val(),
           idFlow: idFlow, 
           identifier: identifier,   
           actionStepUser:actionStepUser,

        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {
            $("#cargandoDiv").css('display', 'none');
           // $('#selectUserPermission').remove();

            $("#permissionModalS #permtable").html(result);
            $('#selectUserPermission').selectpicker();
            $('#selectUserPermission').on('changed.bs.select', function (e, clickedIndex, isSelected, previousValue) {
                select_permission(e, clickedIndex , 'body_table_permission',actions2);       
            });                        
            if(saveMode == 1){
                $("#permissionModalS").modal("hide");
            }    
        },
        error: function(request, status, error) {           
            alert(request.responseText);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            $("#cargandoDiv").css('display', 'none');
            $("#permissionModalS").modal("hide");
          
        }
    });
    
}
