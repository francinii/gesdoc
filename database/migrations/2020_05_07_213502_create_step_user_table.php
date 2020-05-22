<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->timestamps();
            $table->string('step_id');  
            $table->bigInteger('flow_id')->unsigned();   
            $table->string('username'); 
        
            $table->primary(['step_id','flow_id','username'],'step_user_pk');

            $table->foreign('flow_id')->references('flow_id')->on('steps')->onDelete('cascade');           
            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_users');
    }
}
