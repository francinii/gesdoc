<?php

use Illuminate\Database\Seeder;

class Rol extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rols')->insert(array(
            'description' =>"SuperAdmin"       
        ));

        \DB::table('rols')->insert(array(
            'description' =>"Administrador"       
        ));

        \DB::table('rols')->insert(array(
            'description' =>"Usuario"       
        ));
    }
}
