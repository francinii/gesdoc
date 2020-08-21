<?php

use Illuminate\Database\Seeder;

class Permission_Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Id 1
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>1,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 2
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>2,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 3
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>3,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 4         
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>4,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 5        
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>5,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 6        
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>6,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));

        // Id 7       
        \DB::table('permission_role')->insert(array(            	
            'role_id' =>1,
            'permission_id' =>7,
            'created_at'=> '2020-05-02 00:00:00',
            'updated_at'=> '2020-05-02 00:00:00',       
        ));
    }
}
