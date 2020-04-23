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
        'create' => [  
            'title' => 'Nuevo documento',  
            'name' => 'Nombre del documento',  
            'flow' => 'Asociar un flujo',                  
        ],

        'edit' => [
            'title' => 'Editar documento',  
            'name' => 'Nombre del documento', 
            'flow' => 'Flujo asociado',  
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
            'title' => 'Nueva clasificacion',  
            'name' => 'Nombre de la clasificacion',             
        ],

        'edit' => [
            'title' => 'Editar clasificacion',  
            'name' => 'Nombre del clasificacion', 
        ],

        'index' => [
            'title' => 'Departamentos del sistema',
        ],

        'list' => [
            'title' => '',
        ],

        'table' => [
            'id' => 'Id',
            'type' => 'tipo',
            'description' => 'Clasificación',
            'create'=> 'Creado',
            'modified'=> 'Modificado',
            'edit' => 'Editar clasificación',
            'delete' => 'Eliminar clasificación',
        ],
        'menu' => [
            'option1' => 'Mis documentos',
            'option2' => 'Mis flujos',
        ],
    ],

];
