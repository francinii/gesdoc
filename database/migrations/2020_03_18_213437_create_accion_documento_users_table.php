<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccionDocumentoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accion_documento_usuarios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->timestamps();

            $table->bigInteger('documento_usuario_id')->unsigned()->nullable();   
            $table->bigInteger('accion_id')->unsigned()->nullable();  

            $table->foreign('documento_usuario_id')->references('id')->on('documento_users')->onDelete('cascade');
            $table->foreign('accion_id')->references('id')->on('accions')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accion_documento_usuarios');
    }
}
