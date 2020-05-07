<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('username')->nullable();  
            $table->bigInteger('role_id')->unsigned()->nullable();  
            $table->bigInteger('department_id')->unsigned()->nullable(); 
            $table->string('name');            
            $table->string('email');
            $table->string('password');
            $table->timestamps();     
            
            $table->primary('username');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('set null');                   
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
