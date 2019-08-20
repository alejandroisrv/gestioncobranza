<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_ventas', function (Blueprint $table) {
            $table->increments('id')->unique()->unsigned();  
            $table->integer('producto');
            $table->integer('cantidad');
            $table->integer('venta_id')->unsigned();
            $table->timestamps();
            $table->index(['id']);
            $table->foreign('venta_id')->references('id')->on('ventas')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productos_ventas');
    }
}
