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
            'flujo_id' =>1,
            'description' =>"Doc 1",            
        ));
        \DB::table('documentos')->insert(array(
            'flujo_id' =>1,
            'description' =>"Doc 2",            
        ));
    }
}

