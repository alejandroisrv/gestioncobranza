<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBodegaTabla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bodegas', function (Blueprint $table) {
            $table->increments('id')->unique()->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->integer('encargado_id')->unsigned();
            $table->string('telefono',30);
            $table->string('direccion',100);
            $table->integer('municipio_id')->unsigned();
            $table->timestamps();
            $table->index(['id']);
            $table->engine = "InnoDB";
            
            
        });
        Schema::table('bodegas', function($table) {
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
            $table->foreign('encargado_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bodegas');
        Schema::dropIfExists('productos');
    }
}
