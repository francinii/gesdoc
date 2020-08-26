<?php

return [
    /*
    |--------------------------------------------------------------------------
    | App Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain information of the app.
    |
    */
    'buttons' => [    
        'add' => 'Agregar',  
        'update' => 'Actualizar', 
        'edit' => 'Editar', 
        'delete' => 'Borrar', 
        'accept' => 'Aceptar', 
        'cancel' => 'Cancelar',
        'select'=> 'Seleccione...',             
    ],

    'global'=> [    
        'draggable_inicio' => 'draggable_inicio',  
        'draggable_final' => 'draggable_final', 
          
    ],

    'roles' => [    
        'create' => [  
            'title' => 'Nuevo rol',  
            'name' => 'Nombre del rol',             
        ],

        'edit' => [
            'title' => 'Editar rol',  
            'name' => 'Nombre nuevo del rol', 
            'permission' => 'Permisos asociados', 
        ],

        'index' => [
            'title' => 'Roles del sistema',
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'description' => 'Descripción del Rol',
            'permission' => 'Permisos asociados',
            'user' => 'Usuarios asociados',
            'edit' => 'Editar Rol',
            'delete' => 'Eliminar Rol',
        ],

    ],

 
    'users' => [    
        'create' => [  
            'title' => 'Nuevo usuario',  
            'user' => 'Usuario',     
            'username' => 'Nombre de usuario', 
            'name' => 'Nombre',    
            'email' => 'Correo', 
            'role' => 'Rol asociado', 
            'department' => 'Departmaneto asociado',  
            'password' => 'Contraseña',                         
        ],

        'edit' => [
            'title' => 'Nuevo usuario',  
            'user' => 'Usuario',     
            'username' => 'Nombre de usuario', 
            'name' => 'Nombre',    
            'email' => 'Correo', 
            'role' => 'Rol asociado', 
            'department' => 'Departmaneto asociado',  
            'password' => 'Cambiar contraseña',  
            'passwordnew' => 'Nueva contraseña',  
        ],

        'index' => [
            'title' => 'Usuarios del sistema',
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'user' => 'Usuario',
            'name' => 'Nombre',
            'email' => 'Correo',
            'role' => 'Rol asociado',
            'edit' => 'Editar usuario',
            'delete' => 'Eliminar usuario',
        ],

    ],

    'userDocFlow' => [    
        'index' => [
            'title' => 'Documentos compartidos en flujo',
        ],

        'table' => [
            'code' => 'Código',
            'document' => 'Documento',
            'preview' => 'Vista Previa',
            'versions' => 'Versiones',

        ],

    ],

    'documentFlow' => [    
        'index' => [
            'title' => 'Documentos asociados a mis  flujos',
        ],

        'table' => [
            'code' => 'Código',
            'document' => 'Documento',
            'state' => 'Estado',
            'preview' => 'Vista Previa',
            'versions' => 'Versiones',
            'location' => 'Ubicación',
        ],
        'actionHistory' => [
            'title' => 'Acciones sobre la versión: ',
            'dateBegin' => 'Fecha de creación:',
            'dateUpdate' => 'Fecha de modificación',
            'responsable' => 'Realizado por:',
            'id' => 'Identificación',
            'description' => 'Descripción',
            'noInformation' => 'No hay acciones asociadas a esta versión.',      
        ],

        'actualVersion' => [
            'title' => 'Version actual: ',
            'notes' => 'Notas',
            'upload' => 'Subir archivo',
            'edit' => 'Editar archivo',
            'executeActionDes' => 'Ejecutar acción sobre el documento ',
            'executeAction' => 'Ejecutar acción ',
            'description' => 'Descripción',
            'noInformation' => 'No hay acciones asociadas a esta versión.',      
        ],

        'card' => [
            'title' => 'Acciones sobre la versión: ',
            'version' => 'Versión:',
            'dateBegin' => 'Fecha de creación:',
            'dateUpdate' => 'Fecha de modificación:',
            'type' => 'Tipo:',
            'size' => 'Tamaño:', 
        ],

        'historial' => [
            'document' => 'Documento:',
            'code' => 'Código:',
            'owner' => 'Fecha de modificación:',
        ],

        'location' => [
            'title' => 'Ubicación del documento',
            'actualStep' => 'El documento se encuentra actualmente en el paso:',
            'user' => 'Usuarios asociados al paso:',
            'noStep' => 'El documento no está asociado a un paso en el flujo.',
            'userStep' => 'Usuarios asociados al paso.',
            'username' => 'Usuario',
            'name' => 'Nombre',
            'email' => 'Correo',
            'close' => 'Cerrar',   
            
        ],

        'modalEditVersion' => [
            'title' => 'Acciones sobre el flujo de la version ',
            'description1' => 'Al ejecutar "una acción de flujo" sobre el documento actual, se enviará esta versión al siguiente paso del flujo. Al hacer esto,',
            'description2' => 'NO podrá editar esta versión nuevamente',
            'description3' => 'únicamente podrá ver dicho documento o las versiones anteriores a este.',
            'addNote' => 'Agregar notas',
            'note' => 'Notas',
            'save' => 'Save',
            'close' => 'Cerrar',               
        ],

        'notes' => [
            'title' => 'Notas de la versión: ',              
        ],

        'notesContent' => [
            'dateBegin' => 'Fecha de creación:',
            'dateUpdate' => 'Fecha de modificación:',
            'content' => 'Contenido',
            'noInfo' => 'No hay notas asociadas a esta versión', 
        ],

        'notesModal' => [
            'close' => 'Cerrar',   
            'title' => 'Notas asociadas a la versión:',
        ],    

        'oldVersion' => [
            'title' => 'Versión anterior ',   
        ],

        'oldVersion' => [
            'title' => 'Versión anterior ',   
        ],

        'previewHistory' => [
            'title' => 'Versión',   
        ],

        'upload' => [
            'title' => 'Subir documento',
            'import' => 'Importar documento',
        ],

    ],

    
    'departments' => [    
        'create' => [  
            'title' => 'Nuevo departamento',  
            'name' => 'Nombre del departamento',             
        ],

        'edit' => [
            'title' => 'Editar departamento',  
            'name' => 'Nombre del departamento', 
        ],

        'index' => [
            'title' => 'Departamentos del sistema',
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'description' => 'Departamento',
            'edit' => 'Editar documento',
            'delete' => 'Eliminar documento',
        ],
    ],

    'flows' => [    
        'create' => [  
            'title' => 'Nuevo flujo',  
            'name' => 'Nombre del flujo', 
            'save' => 'Guardar flujo', 
            'addBegin' => 'Agregar inicio',             
            'addStep' => 'Agregar paso', 
            'addFinal' => 'Agregar final', 
        ],

        'edit' => [
            'title' => 'Editar flujo',  
            'name' => 'Nombre del flujo', 
            'property' => 'Pasar la propiedad del flujo', 
        ],

        'index' => [
            'title' => 'Flujos del sistema',
        ],

        'list' => [
            'title' => 'Departamento',
        ],

        'line' => [
            'title' => 'Acciones',
            'action' => 'Acción',
            'delete' => 'Eliminar linea',
        ],

        'permission' => [
            'save' => 'Guardar Paso',
            'saveClose' => 'Guardar y cerrar',
            'title' => 'Asociar permisos a usuarios',
            'step' => 'Paso',        
        ],


        'table' => [
            'id' => 'Id',
            'description' => 'Flujo',
            'owner' => 'Creado por',
            'edit' => 'Editar flujo',
            'delete' => 'Eliminar flujo',
            'state' => 'Estado',
            'permission' => 'Permisos',
            'clone' => 'Copiar',
            'editSee' => 'Ver/Editar Flujo',
            'stateActive' => 'Activo',
            'stateInactive' => 'Inactivo',
            'secureDelete' => '¿Desea eliminar el flujo:',
            
        ],

        'card' => [
            'title' => 'Descripción del Departamento',
            'user' => 'Usuarios asociados',
            'userAssociate' => 'Asociar permisos a usuarios ',
            'name' => 'Nombre',
            'username' => 'Usuario',
            'email' => 'Correo',
            'delete' => 'Eliminar',
            'save' => 'Guardar',

        ],

        'permissionTable' => [
            'title' => 'Agregar Usuario',
            'username' => 'Usuario',
            'name' => 'Nombre',
            'delete' => 'Quitar permisos',

        ],

    ],

    'documents' => [ 
        'general' =>[
            'name' => 'Nombre del documento',              
            'code' => 'Código del documento',
            'languaje' => 'Idioma del contenido', 
            'summary' => 'Resumen de contenido',    
            'others' => 'Otros datos',  

        ],
        'create' => [  
            'title' => 'Nuevo documento',
            'flow' => 'Asociar un flujo', 
            'classification' => 'Asociar una classificación',   
            
        ],

        'edit' => [
            'title' => 'Editar documento',  
            'flow' => 'Flujo asociado',
            'classification' => 'Classificación asociada',   
        ],

        'index' => [
            'title' => 'Documentos del sistema',
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'description' => 'Documento',
            'flow' => 'Flujo asociado',
            'edit' => 'Editar documento',
            'delete' => 'Eliminar documento',
        ],

        'textEditor' => [
            'save' => 'Guardar',  
            'download' => 'Descargar',
            'share' => 'Compartir', 
            'import' => 'Importar',   
        ],

        'wopihost' => [
            'title' => 'Versiones',  
             
        ],
    ],
    'home' => [    
        'create' => [  
            'title' => 'Nueva clasificación',  
            'name' => 'Nombre de la clasificación',     
                      
        ],

        'edit' => [
            'title' => 'Editar',  
            'name' => 'Nombre', 
            'move' => 'Mover a ',
            
        ],

        'index' => [
            'title' => 'Departamentos del sistema',
            'advancedSearch' => 'Busqueda avanzada',
            'otherFilters' => 'Otros',
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'summary' => 'Resumen',
            'code' => 'Codigo',
            'flow_id' => 'Flujo',
            'stade'=>'Estado',
            'languaje' => 'Idioma',
            'numberDocuments' => 'Numero de Documentos:',
            'others' => 'Otros',
            'classification' => 'classification',
            'type' => 'tipo',
            'description' => 'Nombre',
            'create'=> 'Creado',
            'modified'=> 'Modificado',
            'edit' => 'Editar clasificación',
            'delete' => 'Eliminar clasificación',
            'defaultClassification' => 'Principal', 
            'defaultShareClassification' => 'Compartido conmigo', 
        ],
        'menu' => [
            'option1' => 'Mis documentos',
            'option2' => 'Compartidos conmigo',
            'option3' => 'Mis flujos',
            'option4' => 'Documentos',
            'option5' => 'Agregar',
            'option6' => 'Importar Documento',
            
        ],

        'contextMenu' => [
            'delete' => 'Eliminar',
            'remove' => 'Quitar',
            'createClassification' => 'Crear clasificación',
            'editClassification' => 'Editar',
            'createDocument' => 'Crear documento',
            'createSheet' => 'Crear hoja de cálculo',
            'createPPT' => 'Crear presentación',
            'share' => 'compartir',
            'copy' => 'Hacer una copia',
        ],

        'share' => [
            'share'=>'Compartir',
            'shareWithUser' => 'Compartir con usuarios',
            'AsociatePermission' => 'Asociar Persmisos',
            'user' =>'Usuario',
            'name' =>'Nombre' ,
            'email' =>'Correo'   ,                               
            'delete' =>'Eliminar',
            'owner' =>'Propietario',
        ],
        

    ],
    'record'=>[
        'index'=>[
            'title'=>'Historial de acciones'
        ],
        'table'=>[
            'user'=>'Usuario',
            'action'=>'Acción',
            'description'=>'Descripción',
            'document'=>'Documento',
            'version'=>'Versión',
            'Flow'=>'Flujo',
            'create'=> 'Creado',
            'modified'=> 'Modificado',

        ]
    ],

    'login' => [
        'username'=>'Usuario',
        'password'=>'Contraseña',
        'login'=>'Iniciar sesión',
        'rememberMe' =>'Recuerdame',
        'signUp' =>'Entrar',
    ]

];
