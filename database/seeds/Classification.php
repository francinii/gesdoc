<?php

use Illuminate\Database\Seeder;

class Classification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('classifications')->insert(array(
            'description' =>"Sin clasificar",
           
        ));
        \DB::table('classifications')->insert(array(
            'description' =>"Documentos personales",
           
        ));
        \DB::table('classifications')->insert(array(
            'description' =>"Documentos del trabajo",
           
        ));
    }
}
