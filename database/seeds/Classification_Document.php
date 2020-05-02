<?php

use Illuminate\Database\Seeder;

class Classification_Document extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('Classification_Document')->insert(array(
            'classification_id'=>1,
            'document_id'=>1,       
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',          
        ));

        \DB::table('Classification_Document')->insert(array(
            'classification_id'=>1,
            'document_id'=>2,       
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',          
        ));
    }
}
