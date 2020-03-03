<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rols')->insert(array(
            'id' =>"1" ,
            'description' =>"Administrar roles"       
        ));
        \DB::table('rols')->insert(array(
            'id' =>"2" ,
            'description' =>"Administrar permisos"       
        ));
    }
}
