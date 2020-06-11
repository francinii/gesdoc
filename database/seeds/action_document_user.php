<?php

use Illuminate\Database\Seeder;

class action_document_user extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('action_document_user')->insert(array(
            'action_id'=>4,
            'document_id'=>1,
            'username'=> "116650288",
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
    }
}
