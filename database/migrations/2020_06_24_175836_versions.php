<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Versions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('document_id')->unsigned(); 
            $table->text('content'); //content or route depends on
            $table->string('size',500);    //numero y unidad de medida mb gb etc   
            $table->string('type',500);   //ejemplo png, xls, doc, txt etc. 
            $table->decimal('version', 3, 1);   //ejemplo png, xls, doc, txt etc.     
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
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
        Schema::dropIfExists('versions');
    }
}
