<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaArticulos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('id_articulo');
            $table->string('descripcion')->required();
            $table->string('unidad', 20)->required();
            $table->integer('stock_actual');
            $table->integer('stock_minimo')->nullable();
            $table->string('usuario')->nullable(); //achicar caracteres
            $table->integer('id_rubro')->unsigned()->required();
            $table->foreign('id_rubro')->references('id_rubro')->on('rubros');
            $table->integer('id_subrubro')->unsigned()->nullable();
            $table->foreign('id_subrubro')->references('id_subrubro')->on('subrubros');
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
        Schema::drop('articulos');
    }
}