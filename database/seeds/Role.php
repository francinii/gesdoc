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
        \DB::table('roles')->insert(array(
            'description' =>"SuperAdmin"       
        ));

        \DB::table('roles')->insert(array(
            'description' =>"Administrador"       
        ));

        \DB::table('roles')->insert(array(
            'description' =>"Usuario"       
        ));
    }
}
