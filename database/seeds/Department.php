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
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('departments')->insert(array(
            'description' =>"Escuela de Matemática",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
         
        ));
    }
}
