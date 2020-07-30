<?php

use Illuminate\Database\Seeder;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      /*  \DB::table('users')->insert(array(
            'name' =>"FRANCINI CORRALES",
            'username' =>"116650288",
            'email' =>"francini.corrales.garro@una.ac.cr",
            'rol_id'  => 1,
            'password' => Hash::make('12345678')
        )); */

        \DB::table('users')->insert(array(
            'name' =>"DANNY VALERIO",
            'username' =>"402340420",
            'email' =>"danny.valerio.ramirez@est.una.ac.cr",
            'role_id'  => 1,
            'department_id'  => 1,
            'password' => Hash::make('12345678'),
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
            'api_token'=>'$2y$10$SKpw98ivNqr1AeKd8aFRh.EYwT2GApPNe1eQ9/ELby3vrYNuPeVVS',
        ));

        \DB::table('users')->insert(array(
            'name' =>"FRANCINI CORRALES",
            'username' =>"116650288",
            'email' =>"francini.corrales.garro@est.una.ac.cr",
            'role_id'  => 1,
            'department_id'  => 1,
            'password' => Hash::make('12345678'),
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',
            'api_token'=>'$2y$10$SKpw98ivNqr1AeKd8aFRh.EYwT2GApPNe1eQ9/ELby3vrYNuPeVVS',
        ));
        


    }
}
