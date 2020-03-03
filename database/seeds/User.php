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
            'name' =>"MARIA ELENA CORRALES",
            'username' =>"116780195",
            'email' =>"maria.corrales.garro@una.ac.cr",
            'rol_id'  => 1,
            'password' => Hash::make('12345678')
        ));

        \DB::table('users')->insert(array(
            'name' =>"TATIANA CORRALES",
            'username' =>"402340421",
            'email' =>"tatiana.corrales.palma@una.ac.cr",
            'rol_id'  => 1,
            'password' => Hash::make('12345678')
        ));

        \DB::table('users')->insert(array(
            'name' =>"DANNTY VALERIO",
            'username' =>"402340420",
            'email' =>"danny.valerio.ramirez@una.ac.cr",
            'rol_id'  => 1,
            'password' => Hash::make('12345678')
        ));

    }
}
