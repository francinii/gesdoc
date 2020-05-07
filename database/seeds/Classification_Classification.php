<?php

use Illuminate\Database\Seeder;

class Classification_Classification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('classification_classification')->insert(array(
            'first_id' =>1,
            'second_id' =>2,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classification_classification')->insert(array(
            'first_id' =>1,
            'second_id' =>3,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
    }
}
