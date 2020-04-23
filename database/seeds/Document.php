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
            'flow_id' =>1,
            'classification_id'=>1,
            'description' =>"Doc 1",            
        ));
        \DB::table('documents')->insert(array(
            'flow_id' =>1,
            'classification_id'=>1,
            'description' =>"Doc 2",            
        ));
    }
}

