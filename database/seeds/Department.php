<?php

use Illuminate\Database\Seeder;

class Department extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('departments')->insert(array(
            'description' =>"Escuela de Informática",
           
        ));
        \DB::table('departments')->insert(array(
            'description' =>"Escuela de Matemática",
         
        ));
    }
}
