<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionClassificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_classification_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';      
            $table->bigInteger('action_id')->unsigned();
            $table->bigInteger('classification_id')->unsigned();  
            $table->string('username');
              
            $table->timestamps();

            $table->primary(['action_id','classification_id','username'],'action_classification');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade');
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
        Schema::dropIfExists('action_classification_user');
    }
}
