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
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Rechazado",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Aceptado con modificaciones",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Parcialmente aceptado",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Ver",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Editar",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
    }
}
