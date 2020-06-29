<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistorialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historials', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->bigIncrements('id');            
            $table->bigInteger('action');
            $table->string('username');
            $table->string('user_id');            
            $table->text('description'); //content or route depends on
            $table->bigInteger('document_id');
            $table->bigInteger('document_name'); 
            $table->bigInteger('version_id');
            $table->bigInteger('flow_id');   
            $table->bigInteger('flow_name');        
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
        Schema::dropIfExists('historials');
    }
}
