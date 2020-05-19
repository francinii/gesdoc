<?php

use Illuminate\Database\Seeder;

class Action extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('actions')->insert(array(
            'description' =>"Aceptado",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Rechazado",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Aceptado con modificaciones",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Parcialmente aceptado",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Ver",
            'type' =>0,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Editar",
            'type' =>0,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
    }
}
