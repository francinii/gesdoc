<?php

use Illuminate\Database\Seeder;

class Permiso extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permisos')->insert(array(
            'description' =>"Ingreso a los roles del sistema"       
        ));
        \DB::table('permisos')->insert(array(
            'description' =>"Ingreso a los usuarios del sistema"       
        ));
        \DB::table('permisos')->insert(array(
            'description' =>"Creación de documentos"       
        ));
    }
}
