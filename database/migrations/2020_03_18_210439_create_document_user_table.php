<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';            
            $table->bigInteger('document_id')->unsigned()->nullable();   
            $table->string('username')->nullable();    
            $table->timestamps();

            $table->primary(['document_id','username']);
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
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
        Schema::dropIfExists('document_user');
    }
}
