<?php

use Illuminate\Database\Seeder;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Id 1 This role can't be edited in the system 
        \DB::table('roles')->insert(array(
            'description' =>"SuperAdmin",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));

        \DB::table('roles')->insert(array(
            'description' =>"Administrador",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        \DB::table('roles')->insert(array(
            'description' =>"Usuario",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));
    }
}
