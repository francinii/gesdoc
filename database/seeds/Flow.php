<?php

use Illuminate\Database\Seeder;

class Flow extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('flows')->insert(array(
            'user_id' =>1,
            'description' =>"Flujo cargas académicas",            
        ));
        \DB::table('flows')->insert(array(
            'user_id' =>1,
            'description' =>"Flujo de cargas docentes",            
        ));
    }
}
