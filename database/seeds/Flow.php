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
            'username'=>'402340420',
            'description' =>"Flujo cargas académicas",   
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',         
        ));
        \DB::table('flows')->insert(array(
            'username'=>'402340420',
            'description' =>"Flujo de cargas docentes", 
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',           
        ));
    }
}
