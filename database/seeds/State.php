<?php

use Illuminate\Database\Seeder;

class State extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('states')->insert(array(
            'description' =>"Nuevo",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00', 
            'color'=> '#007bff',      
        ));
        \DB::table('states')->insert(array(
            'description' =>"Aceptado",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00', 
            'color'=> '#218838', 
        ));
        \DB::table('states')->insert(array(
            'description' =>"Rechazado",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00', 
            'color'=> '#c82333',     
        ));
        \DB::table('states')->insert(array(
            'description' =>"Aceptado con modificaciones",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00', 
            'color'=> '#ffc107',       
        ));
        
    }
}
