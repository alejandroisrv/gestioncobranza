<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id')->unique()->unsigned();
            $table->integer('bodega_id')->unsigned();
            $table->integer('sucursal_id')->unsigned();
            $table->string('nombre',100)->unique();
            $table->decimal('precio_costo',10,3);
            $table->decimal('precio_revendedor',10,3);
            $table->decimal('comision',10,3);
            $table->integer('cantidad');
            $table->timestamps();
            $table->index(['id']);
            $table->foreign('bodega_id')->references('id')->on('bodegas')->onDelete('cascade');
            $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos');
    }
}
