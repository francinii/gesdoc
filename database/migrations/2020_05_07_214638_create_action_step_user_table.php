<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionStepUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_step_user', function (Blueprint $table) {
            $table->timestamps();          
            $table->bigInteger('step_id')->unsigned()->nullable();  
            $table->string('username')->nullable(); 
            $table->bigInteger('action_id')->unsigned()->nullable();              
            $table->primary(['step_id','username','action_id']);
            $table->foreign('step_id')->references('step_id')->on('step_user')->onDelete('cascade');
            $table->foreign('username')->references('username')->on('step_user')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_step_users');
    }
}
