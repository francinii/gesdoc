<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificationDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classification_document', function (Blueprint $table) {
           
            $table->bigInteger('classification_id')->unsigned()->nullable();
            $table->bigInteger('document_id')->unsigned()->nullable();
            $table->timestamps();

            $table->primary(['classification_id','document_id']);
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('set null'); 
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('set null'); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classification_document');
    }
}
