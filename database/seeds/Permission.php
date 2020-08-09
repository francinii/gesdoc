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
        // Id 1
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a la administración de roles del sistema.",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 2
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a la administración de usuarios del sistema.",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',   
        ));

        // Id 3
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a la administración de departamentos del sistema",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

        // Id 4
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a la administración de flujos del sistema",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

        // Id 5
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a los documentos asociados a mis flujos",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

        // Id 6
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso a los documentos compartidos en flujo",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

        // Id 7
        \DB::table('permissions')->insert(array(
            'description' =>"Ingreso al historial",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

    }
}
