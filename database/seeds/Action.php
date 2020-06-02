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
        //Type 0 > It's for actions related to the flow
        //Type 1 >  It's for actions related to Documents
        //Type 2 > It's for the specific action begin (Beginning line in the flow)
        \DB::table('actions')->insert(array(
            'description' =>"Aceptado",
            'type' =>0,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Rechazado",
            'type' =>0,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Inicio",
            'type' =>2,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Ver",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        \DB::table('actions')->insert(array(
            'description' =>"Editar",
            'type' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',      
        ));
        
    }
}
