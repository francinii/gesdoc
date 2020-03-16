<?php

use Illuminate\Database\Seeder;

class Instancia extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('instancias')->insert(array(
            'description' =>"Escuela de Informatica",
            'academic_unit' =>"CIencias exactas y naturales",
        ));
        \DB::table('instancias')->insert(array(
            'description' =>"Escuela de Matematica",
            'academic_unit' =>"CIencias exactas y naturales",
        ));
    }
}
