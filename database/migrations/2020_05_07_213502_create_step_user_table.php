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
            $table->timestamps();
            $table->bigInteger('step_id')->unsigned()->nullable();  
            $table->string('username')->nullable(); 
            $table->primary(['step_id','username']);
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
