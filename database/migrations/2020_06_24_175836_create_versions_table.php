<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versions', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->bigIncrements('id');
            $table->bigInteger('document_id')->unsigned(); // fk doc
            $table->bigInteger('flow_id')->unsigned()->nullable();  // fk step
            $table->string('identifier')->nullable();  //fk step
            $table->text('content'); //content or route depends on
            $table->string('size',500);    //numero y unidad de medida mb gb etc   
            $table->boolean('status');   //ejemplo png, xls, doc, txt etc. 
            $table->decimal('version', 3, 1);   //ejemplo png, xls, doc, txt etc.   
             
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->foreign(['flow_id','identifier'])->references(['flow_id','id'])->on('steps')->onDelete('cascade');
           
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
