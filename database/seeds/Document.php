<?php

use Illuminate\Database\Seeder;

class Document extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('documents')->insert(array(
            'flow_id' =>null,            
            'description' =>"Doc 1", 
            'type' =>"doc",   
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',    
        ));
        \DB::table('documents')->insert(array(
            'flow_id' =>null,            
            'description' =>"Doc 2",   
            'type' =>"xls",  
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',         
        ));
    }
}

