<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meses', function (Blueprint $table) {
            $table->id();
            $table->string('mes');
            
            $table->foreignId('gestion_id');
            $table->foreign('gestion_id')->references('id')->on('gestiones')->onDelete('cascade');
            $table->foreignId('estado_compras');
            $table->foreign('estado_compras')->references('id')->on('estados')->onDelete('cascade');
            $table->foreignId('estado_ventas');
            $table->foreign('estado_ventas')->references('id')->on('estados')->onDelete('cascade');
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
        Schema::dropIfExists('meses');
    }
}
