<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sucursales', function (Blueprint $table) {
            $table->increments('id')->unique()->unsigned();
            $table->integer('encargado_id')->unsigned();    
            $table->string('telefono',30);
            $table->string('direccion',100);
            $table->integer('municipio_id')->unsigned(); 
            $table->timestamps();
            $table->index(['id']);
            $table->engine = "InnoDB";
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sucursales');
    }
}
