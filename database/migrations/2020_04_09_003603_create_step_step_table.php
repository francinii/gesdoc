<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStepStepTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('step_step', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigInteger('preview_step_id')->unsigned()->nullable();  
            $table->bigInteger('next_step_id')->unsigned()->nullable(); 
            $table->timestamps();

            $table->primary(['preview_step_id','next_step_id']);
            $table->foreign('preview_step_id')->references('id')->on('steps')->onDelete('cascade');
            $table->foreign('next_step_id')->references('id')->on('steps')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('step_step');
    }
}
