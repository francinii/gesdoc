/**
* global variable   
*
*/
var idselect;
var descriptionEdit;
var typeContextMenu;
var currentClassification;
var listClassification = [];
var allClassifications;
var usersShare=[];
var currentTable="1"; // 1 = my documents, 2 share with me, 3 my documents in flows
var isCurrentUserOwner;
var CanCurrentUserEditar; 
var CanCurrentUserDetele;
/**
* draw the route follow for the user  
*
*/

function definePermmisision(myActions){
    (myActions.findIndex(x => x == 'owner')!=-1)? isCurrentUserOwner=true:isCurrentUserOwner=false;
    (isCurrentUserOwner || myActions.findIndex(x => x.action_id == 5)!=-1)? CanCurrentUserEditar=true:CanCurrentUserEditar=false;
    (isCurrentUserOwner || myActions.findIndex(x => x.action_id == 6)!=-1)? CanCurrentUserDetele=true:CanCurrentUserDetele=false;
}
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
        idselect = "";
        descriptionEdit = "";
        if (td.className != "dataTables_empty") {
            typeContextMenu =td.parentNode.childNodes[1].childNodes[1].innerText;
            idselect = td.parentNode.childNodes[9].innerText;
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
            $("#createClassificationContext").hide();
            $("#editContext").hide();
            $("#deleteContext").hide();
            $("#shareContext").hide();
            $("#createDocumentContext").hide();
            $("#createSheetContext").hide();
            
                 
            if(currentClassification.type==1 && td.className == "dataTables_empty" && currentTable==1){    
                $("#createClassificationContext").show();
                $("#createDocumentContext").show();     
                $("#createSheetContext").show();          
            }else if(currentClassification.type==1 && currentTable==1 ){
                $("#createClassificationContext").show();
                $("#createDocumentContext").show();
                $("#createSheetContext").show();
                $("#editContext").show();
                $("#deleteContext").show();
                $("#shareContext").show();
            }
            else if(currentTable==2 && currentClassification.type==2 && td.className != "dataTables_empty" ){    
                $("#editContext").show();
                $("#deleteContext").show();
                $("#shareContext").show();  
            }
            else if(currentClassification.type==3 && td.className != "dataTables_empty" && (isCurrentUserOwner || CanCurrentUserEditar)){
                $("#editContext").show();
                $("#createDocumentContext").show();
                $("#createSheetContext").show();
                $("#deleteContext").show();
                $("#shareContext").show();                
            }else if(isCurrentUserOwner || CanCurrentUserEditar){
                $("#createDocumentContext").show();
                $("#createSheetContext").show();
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
function ajaxCreate(){
    var me = $(this);

    if (me.data("requestRunning"))
        return;
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
                currentTable:currentTable,
                description: description,
            },
            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function (result) {
                me.data("requestRunning", false);
                $("#table").DataTable().destroy();
                $("#divTable").html(result);

                createDataTable("table");
                $("#create").modal("hide");
                alerts('alerts', 'alert-content',
                    "La clasificacion " +
                        description +
                        " ha sido agregado satisfactoriamente",
                    "alert-success"
                );
                
                $("#cargandoDiv").css('display', 'none')
            },
            error: function (request, status, error) {
                me.data("requestRunning", false);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);
                
                $("#cargandoDiv").css('display', 'none')
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
    $("input[id=idEdit]").val(idselect);
    $("input[name=descriptionEdit]").removeClass("is-invalid");
    $("input[name=descriptionEdit]").val(descriptionEdit);
    

    $("#edit").modal("show");
}


/**
 * open a classification
 *
 * @param {Integer} id of the classification opend
 * 
 */
function openClassification(id) {
    var me = $(this);
    if (me.data("requestRunning"))
        return;    
    me.data("requestRunning", true);

    $.ajax({
        url: "home/"+currentTable+"/"+id,
        method: "get",

        data: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            _token: $("input[name=_token]").val(),
            currentTable:currentTable,
            id: id,
        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function (result) {
            me.data("requestRunning", false);
            $("#table").DataTable().destroy();
            $("#divTable").html(result);
            createDataTable("table");
            $("#create").modal("hide");            
            $("#cargandoDiv").css('display', 'none')
        },
        error: function (request, status, error) {
            me.data("requestRunning", false);
            alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
            alert(request.responseText);
            
            $("#cargandoDiv").css('display', 'none')
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

/**
 * Validate inputs in the edit form.  
 *    
 */
function validaEdit() {
    var validado = true;

    if ($("input[name=descriptionEdit]").val() == "") {
        $("input[name=descriptionEdit]").addClass("is-invalid");
        validado = false;
    } else {
        $("input[name=descriptionEdit]").removeClass("is-invalid");
    }    
    return validado;
}

/**
 * Update a classification
*/

function ajaxUpdate() {
    var me = $(this);

    if (me.data("requestRunning"))
        return;
    me.data("requestRunning", true);

    if (validaEdit()) {
        var id = $("input[id=idEdit]").val();
        var description = $("input[name=descriptionEdit]").val();
    
        $.ajax({
            url: "home/{" + id + "}",
            method: "POST",
           

            data: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                _token: $("input[name=_token]").val(),
                _method: "PATCH",
                id:id,
                currentClassification: currentClassification.id,
                currentTable:currentTable,
                description: description,
        

            },
            beforeSend: function (xhr) { 
                $("#cargandoDiv").css('display', 'block')
            },
            success: function(result) {    
                me.data("requestRunning", false);            
                $("#table").DataTable().destroy();
                $("#divTable").html(result);
                createDataTable("table");
                $("#edit").modal("hide");
                alerts('alerts', 'alert-content',"La clasificación "+description+" ha sido actualizado satisfactoriamente", "alert-success");
                
                $("#cargandoDiv").css('display', 'none')
            },
            error: function(request, status, error) {
                me.data("requestRunning", false);
                alerts('alerts', 'alert-content',"Ha ocurrido un error inesperado.", "alert-danger");
                alert(request.responseText);                
                $("#cargandoDiv").css('display', 'none')
            }
        });
    }
}

/**
 * delete a clasification or document select
 */

function deletefile(){
    var mensaje='Desea eliminar ';
    if(typeContextMenu=='classification'){
        mensaje+="la clasificacion "+descriptionEdit+" y todo su contenido (los documentos en un flujo de trabajo, quedan en la pestaña flujos)";
    }else{
        mensaje+="el documento "+descriptionEdit
    }
    var id=idselect+"-"+typeContextMenu+"-"+currentClassification.id+"-"+currentTable;
    confirmDelete(id,'home','table-divTable',mensaje)

}

/**
 *  open a sheet of the menu  1 = my documents, 2 share with me, 3 my documents in flows
 * @param {Integer} sheet number of the sheet
 */

 function openSheet(sheet){
    currentTable=sheet;
    listClassification = [];
    openClassification(0);
 }

/**
 * clear the lis of users for share
 */
function showshare(){
    var me = $(this);
    if (me.data("requestRunning"))
    return;
    me.data("requestRunning", true);
    
    usersShare=[];
    $("#modal-body-step-back").hide();
    $("#modal-body-step").show();
    

    
    $.ajax({
        url: "home/showshare/"+idselect+"/"+typeContextMenu,
        method: "get",
       

        data: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            _token: $("input[name=_token]").val(),
            id:idselect,
            type:typeContextMenu


        },
        success: function(result) {   
            me.data("requestRunning", false); 
            openShare(result.currentUsersShare,result.documentInClassificationid,result.classificationInClassificationid);
                              
            
        },
        error: function(request, status, error) {
            me.data("requestRunning", false);
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
            alert(request.responseText);
            
        }
    });


}

function openShare(currentUsersShare){
    $("#select_document option:selected").show();
    $("#select_document option:selected").prop("selected", false);    
    $(".body_table").empty();
    currentUsersShare= Object.values(currentUsersShare);
  for (let index = 0; index < currentUsersShare.length; index++) {     
      if(currentUsersShare[index].owner)$('#owner').val(currentUsersShare[index].username);
      appendUserTable(currentUsersShare[index].username, currentUsersShare[index].name, currentUsersShare[index].email, 'body_table',currentUsersShare[index].owner);
      $('#'+currentUsersShare[index].username).prop('selected',true);
      var user={};
      user['username']=currentUsersShare[index].username;
      user['email']=currentUsersShare[index].email;
      user['name']=currentUsersShare[index].name;
      user['owner']=currentUsersShare[index].owner;
      user['type']='old'
      user['actions']=currentUsersShare[index].actions;
      usersShare.push(user);
  }
    $('#select_document').selectpicker('refresh');
    $("#modal-body-share").show();
    $("#modal-body-share-back").hide();
    $('#share').modal('show');
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
 * Add to an specific table the selected users in a combobox.
 * @param {event} e - trigger  the event.
 * @param {int} clickedIndex - selected item.
 * @param {int} tableId - id of the table to add an user.
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
        appendUserTable(username, name, email, tableId,false);
        var index=usersShare.findIndex(x => x.username == username);
        if(index>=0){
            usersShare[index].type='old';
        }else{
        var user={};
            user['username']=username;
            user['email']=email;
            user['name']=name;
            user['owner']=false;
            user['type']='new';
            user['actions']=[4];
            usersShare.push(user);
        }
    }else {
        
        deleteUserTable(tableId,username);
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
function appendUserTable(username, name, email, tableId,owner){
    var index=usersShare.length;
   if(owner){
   $("."+tableId).append(
    "<tr id ='" +  tableId + username +  "'><td>" + username +  "</td><td>" + name + "</td><td>" + email +
    "</td><td id='deleteShareUser'>Propietario</td></tr>"
    );
    $('#'+username).hide();
    $('#select_document').selectpicker('refresh');
    
   }
   else
    $("."+tableId).append(
        "<tr id ='" +  tableId + username +  "'><td>" + username +  "</td><td>" + name + "</td><td>" + email +
        "</td><td id='deleteShareUser'><button class ='btn btn-danger delete' onclick= deleteUserTable('"+ tableId +"','"+username+"') type ='button' ><i class='fas fa-trash-alt'></i></button></td></tr>"
    );
  }

  /**
 * Open a modal with a list of permissions. In this modal you can edit 
 * the permission of each user that you add in the edit modal. 
 * @param {array} actions - List of actions that an user can execute in each step
 * 
 */
function openPermissions(actions){
    $(".body_table_line").empty();
    cadena="";
    chequeado = "";
    habilitado = "";
    usersShare
  for (let index = 0; index < usersShare.length; index++) {
    if(usersShare[index].type!='delete'){
        cadena += '<tr id="pemission-'+usersShare[index].username+'"><input type="hidden" id = "input'+usersShare[index].username+'" value ="'+usersShare[index].email+'"><td id = "'+usersShare[index].username+'">'+usersShare[index].name+'</td>';
        if(usersShare[index].owner){
            cadena +='<td  ><input type="radio" name="owner" onchange="changeOwner(this,'+usersShare[index].username+')" checked><br></td>'
            actions.forEach(action => {  
                if(action.id!=4)      
                cadena += '<td ><input type ="checkbox" class="form-check-input " onchange="selectAccion('+usersShare[index].username+','+action.id+',this)" id = "'+usersShare[index].username+'-'+action.id+'"  disabled></td>';
            });
        }        
        else{
            cadena +='<td ><input type="radio" name="owner" onchange="changeOwner(this,'+usersShare[index].username+')"><br></td>'
            actions.forEach(action => {      
                var actionIndex = usersShare[index].actions.indexOf(action.id); 
                if(action.id!=4)
                if (actionIndex !== -1)             
                    cadena += '<td ><input type ="checkbox" class="form-check-input" onchange="selectAccion('+usersShare[index].username+','+action.id+',this)"  id = "'+usersShare[index].username+'-'+action.id+'" checked></td>';
                else
                    cadena += '<td ><input type ="checkbox" class="form-check-input" onchange="selectAccion('+usersShare[index].username+','+action.id+',this)"  id = "'+usersShare[index].username+'-'+action.id+'"></td>';
            });
        }

        cadena += '</tr>';
    }
  }   
    $(".body_table_line").append(cadena);
    $("#card-title").val('Agregar permisos a usuarios');
    $("#modal-body-share").hide();
    $("#modal-body-share-back").show();
} 

/**
 * Save the permissions that an user has in one step. 
 * 
 */
function backShareUsers(){
    $("#select_document option:selected").show();
    $("#select_document option:selected").prop("selected", false);    
    $(".body_table").empty();
    for (let index = 0; index < usersShare.length; index++) {
        if(usersShare[index].type!='delete'){
            if(usersShare[index].owner)$('#owner').val(usersShare[index].username);
            appendUserTable(usersShare[index].username, usersShare[index].name, usersShare[index].email, 'body_table',usersShare[index].owner);
            $('#'+usersShare[index].username).prop('selected',true);
        }
    }

    $('#select_document').selectpicker('refresh');
    $("#modal-body-share").show();
    $("#modal-body-share-back").hide();
    $('#share').modal('show');

}



/**
 * Delete an user inside the tableUser showed in the editModal step 
 * @param {integer} tableId - id of the table to update
 * @param {string} username - id of the user that is going to be deleted
 * 
 */
function deleteUserTable(tableId, username){       
    var parent=$('#'+tableId+username).parent().prop('id')
        $('#'+tableId+username).remove();
        $('#'+username).prop('selected',false);
        $('#select_document').selectpicker('refresh');

        var index=usersShare.findIndex(x => x.username == username);
        usersShare[index].type=='old'? usersShare[index].type='delete':  usersShare.splice(index, 1);

    
}

function changeOwner(e,username){
    var oldeOwner=$('#owner').val();
    var oldeIndex=usersShare.findIndex(x => x.username == oldeOwner);
    var index=usersShare.findIndex(x => x.username == username);
    $('#owner').val(username);    
    usersShare[index].owner=true;
    usersShare[oldeIndex].owner=false;
    var list= $('#pemission-'+index+' td input:checkbox');
    $('#pemission-'+oldeOwner+' td input:checkbox').prop('disabled',false);
    $('#pemission-'+username+' td input:checkbox').prop('disabled',true);
    usersShare[index].actions=[];
    usersShare[oldeIndex].actions=[4];
    
}

function selectAccion(username,action,evento){
    var checked = evento.checked;
    if(checked){
    var index=usersShare.findIndex(x => x.username == username);
    usersShare[index].actions.push(action)
    }else{
        var index=usersShare.findIndex(x => x.username == username);
        var actionIndex = usersShare[index].actions.indexOf(action);
        if (actionIndex !== -1) usersShare[index].actions.splice(actionIndex, 1);
    }
}

function AjaxShare(){
var me = $(this);
 if (me.data("requestRunning"))
    return;
    me.data("requestRunning", true);
    var classificationOwner=$('#owner').val();  
    
    $.ajax({
        url: "home/share/"+idselect+"/"+typeContextMenu,
        method: "post",
           

        data: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            _token: $("input[name=_token]").val(),            
            idselect:idselect,
            currentClassification: currentClassification.id,
            currentTable:currentTable,
            typeContextMenu:typeContextMenu,
            usersShare:usersShare,
            classificationOwner:classificationOwner,


        },
        beforeSend: function (xhr) { 
            $("#cargandoDiv").css('display', 'block')
        },
        success: function(result) {    
            me.data("requestRunning", false);  
            $("#cargandoDiv").css('display', 'none')          
            $("#table").DataTable().destroy();
            $("#divTable").html(result);
            createDataTable("table");
            $("#share").modal("hide");
            alerts('alerts', 'alert-content',"Usuarios agregados satisfactoriamente", "alert-success");
            usersShare=[];           
            
        },

        error: function(request, status, error) {
            me.data("requestRunning", false);
            $("#cargandoDiv").css('display', 'none')
            alerts("Ha ocurrido un error inesperado.", "alert-danger");
            alert(request.responseText);
            
        }
    });

}
