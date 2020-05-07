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
            'description' =>"Ingreso a los roles del sistema",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a los usuarios del sistema",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',   
        ));
        \DB::table('permissions')->insert(array(
            'description' =>"Creación de documentos",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
    }
}
