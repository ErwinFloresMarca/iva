<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutorizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('autorizaciones', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nro_autorizacion');
            $table->foreignId('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('cascade');
            $table->foreignId('gestion_id');
            $table->foreign('gestion_id')->references('id')->on('gestiones')->onDelete('cascade');
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
        Schema::dropIfExists('autorizacions');
    }
}
