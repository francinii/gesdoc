<?php

use Illuminate\Database\Seeder;

class Documento extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('documentos')->insert(array(
            'flujoId' =>1,
            'description' =>"Doc 1",            
        ));
        \DB::table('documentos')->insert(array(
            'flujoId' =>1,
            'description' =>"Doc 2",            
        ));
    }
}

