<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActionDocumentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_document_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';      
            $table->bigInteger('action_id')->unsigned()->nullable(); 
            $table->bigInteger('document_id')->unsigned()->nullable();   
            $table->string('username')->nullable(); 
              
            $table->timestamps();

            $table->primary(['action_id','document_id','username']);
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
            $table->foreign('document_id')->references('document_id')->on('document_user')->onDelete('cascade');
            $table->foreign('username')->references('username')->on('document_user')->onDelete('cascade');
            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_document_user');
    }
}
