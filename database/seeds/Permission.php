<?php

use Illuminate\Database\Seeder;

class Permission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a los roles del sistema"       
        ));
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a los usuarios del sistema"       
        ));
        \DB::table('permissions')->insert(array(
            'description' =>"Creación de documentos"       
        ));
    }
}
