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
            'type'=>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'116650288',
            'description' =>"Principal",
            'type'=>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'402340420',
            'description' =>"Compartido conmigo",
            'type'=>2,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'116650288',
            'description' =>"Compartido conmigo",
            'type'=>2,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'402340420',
            'description' =>"Documentos personales",
            'type'=>3,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'402340420',
            'description' =>"Documentos del trabajo",
            'type'=>3,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
        \DB::table('classifications')->insert(array(
            'username'=>'116650288',
            'description' =>"fotos",
            'type'=>3,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
           
        ));
    }
}
