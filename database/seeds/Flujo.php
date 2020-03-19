<?php

use Illuminate\Database\Seeder;

class Flujo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('flujos')->insert(array(
            'userId' =>1,
            'description' =>"Flujo cargas académicas",            
        ));
        \DB::table('flujos')->insert(array(
            'userId' =>1,
            'description' =>"Flujo de cargas docentes",            
        ));
    }
}
