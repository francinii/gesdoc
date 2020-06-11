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
            'second_id' =>5,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classification_classification')->insert(array(
            'first_id' =>1,
            'second_id' =>6,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classification_classification')->insert(array(
            'first_id' =>2,
            'second_id' =>7,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classification_classification')->insert(array(
            'first_id' =>4,
            'second_id' =>5,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
    }
}
