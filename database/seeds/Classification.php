<?php

use Illuminate\Database\Seeder;

class Classification extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('classifications')->insert(array(
            'username'=>'402340420',
            'description' =>"Principal",
            'is_Start'=>true,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'116650288',
            'description' =>"Principal",
            'is_Start'=>true,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'402340420',
            'description' =>"Documentos personales",
            'is_Start'=>false,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'402340420',
            'description' =>"Documentos del trabajo",
            'is_Start'=>false,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
    }
}
