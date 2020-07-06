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
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'description' => 'Flujo',
            'owner' => 'Creado por',
            'edit' => 'Editar flujo',
            'delete' => 'Eliminar flujo',
        ],
    ],

    'documents' => [ 
        'general' =>[
            'name' => 'Nombre del documento',              
            'code' => 'Código del documento en la organización',
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
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'summary' => 'summary',
            'code' => 'code',
            'flow_id' => 'flow_id',
            'languaje' => 'languaje',
            'others' => 'others',
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
            
        ],

        'contextMenu' => [
            'delete' => 'Eliminar',
            'remove' => 'Quitar',
            'createClassification' => 'Crear clasificación',
            'editClassification' => 'Editar',
            'createDocument' => 'Crear documento',
            'createSheet' => 'Crear hoja de cálculo',
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

];
