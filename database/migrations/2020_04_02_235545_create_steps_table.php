<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('steps', function (Blueprint $table) {
            $table->engine = 'InnoDB';

           $table->string('id',500);
            $table->bigInteger('flow_id')->unsigned();  
                   
            $table->string('description',500);       
            $table->bigInteger('axisX');
            $table->bigInteger('axisY');  
            $table->primary(['id','flow_id']);
            $table->timestamps();           

            $table->foreign('flow_id')->references('id')->on('flows')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steps');
    }
}
