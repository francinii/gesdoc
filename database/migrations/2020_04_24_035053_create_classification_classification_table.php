<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassificationClassificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classification_classification', function (Blueprint $table) {
            $table->engine = 'InnoDB';
         
            $table->bigInteger('first_id')->unsigned(); 
            $table->bigInteger('second_id')->unsigned(); 
            $table->timestamps();

            $table->primary(['first_id','second_id']);
            $table->foreign('first_id')->references('id')->on('classifications')->onDelete('cascade');
            $table->foreign('second_id')->references('id')->on('classifications')->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classification_classification');
    }
}
