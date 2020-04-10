<?php

use Illuminate\Database\Seeder;

class Step extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('steps')->insert(array(            
            'flow_id' =>"1",  
            'sequence' =>"1",  
            'description' =>"Paso 1",      
        ));
        \DB::table('steps')->insert(array(            
            'flow_id' =>"1",  
            'sequence' =>"2",  
            'description' =>"Paso 2",      
        ));
        \DB::table('steps')->insert(array(            
            'flow_id' =>"1",  
            'sequence' =>"3",  
            'description' =>"Paso 3",      
        ));


        
    }
}
