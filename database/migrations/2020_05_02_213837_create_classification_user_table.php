<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classification_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('classification_id')->unsigned()->nullable();  
            $table->string('username')->nullable(); 
            $table->timestamps();

            $table->primary(['classification_id','username']);
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
        Schema::dropIfExists('classification_user');
    }
}
