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
            $table->string('username',500);
            $table->string('name_user',500);            
            $table->text('description'); //content or route depends on
            $table->bigInteger('document_id');
            $table->string('document_name',500); 
            $table->bigInteger('version_id');
            $table->bigInteger('flow_id')->unsigned()->nullable();  
            $table->string('flow_name',500)->nullable();        
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
