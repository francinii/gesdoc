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
            $table->engine = 'InnoDB';
            $table->bigInteger('classification_id')->unsigned();
            $table->bigInteger('document_id')->unsigned();
            $table->timestamps();

            $table->primary(['classification_id','document_id']);
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade'); 
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade'); 
            
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
