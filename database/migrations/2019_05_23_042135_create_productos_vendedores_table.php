<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosVendedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos_vendedores', function (Blueprint $table) {
            $table->increments('id')->unique()->unsigned();
            $table->integer('producto_id')->unsigned();
            $table->integer('vendedor_id')->unsigned();
            $table->string('producto');
            $table->integer('cantidad');
            $table->integer("estado");
            $table->string("comentario");
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('vendedor_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('productos_vendedores');
    }
}
