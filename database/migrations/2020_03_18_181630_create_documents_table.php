<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('flow_id')->unsigned()->nullable();   
            $table->bigInteger('classification_id')->unsigned()->nullable();
            $table->string('description',500);
       
            $table->timestamps();
            $table->foreign('flow_id')->references('id')->on('flows')->onDelete('set null');
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('set null'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
