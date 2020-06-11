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
            $table->string('prev_step_id');  
            $table->string('next_step_id'); 
            $table->bigInteger('prev_flow_id')->unsigned();  
            $table->bigInteger('next_flow_id')->unsigned(); 
            $table->bigInteger('id_action')->unsigned();
            $table->timestamps();

            $table->primary(['prev_step_id','next_step_id','prev_flow_id','next_flow_id'], 'step_step_pk');
            $table->foreign('prev_step_id','prev_flow_id')->references('id','flow_id')->on('steps')->onDelete('cascade');
            $table->foreign('next_step_id','next_flow_id')->references('id','flow_id')->on('steps')->onDelete('cascade');
            $table->foreign('id_action')->references('id')->on('actions')->onDelete('cascade');

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
