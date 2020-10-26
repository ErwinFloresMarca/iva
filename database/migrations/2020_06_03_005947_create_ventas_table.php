<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('especificacion');
            $table->foreignId("cliente_id");
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreignId("mes_id");
            $table->foreign('mes_id')->references('id')->on('meses')->onDelete('cascade');
            $table->bigInteger('nro_factura')->unique();  
            $table->date('fecha');
            $table->boolean('estado');
            $table->decimal('importe',8,2);
            $table->string('cod_control');
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
        Schema::dropIfExists('ventas');
    }
}
