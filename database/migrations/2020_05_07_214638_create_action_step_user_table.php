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
            $table->engine = 'InnoDB';
                 
            $table->string('step_id'); 
            $table->bigInteger('flow_id')->unsigned(); 
            $table->string('username'); 
            $table->bigInteger('action_id')->unsigned();
            $table->primary(['step_id','flow_id','username','action_id'],'action_step_user_pk');

            $table->foreign('step_id')->references('id')->on('steps')->onDelete('cascade');
            $table->foreign('flow_id')->references('flow_id')->on('steps')->onDelete('cascade'); 
            $table->foreign('username')->references('username')->on('users')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');            
            $table->timestamps();    
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
