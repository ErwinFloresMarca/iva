<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId("proveedor_id");
            $table->foreign('proveedor_id')->references('id')->on('proveedores');
            $table->foreignId("mes_id");
            $table->foreign('mes_id')->references('id')->on('meses');
            $table->bigInteger('nro_factura')->unique();  
            $table->date('fecha');
            $table->decimal('importe',8,2);
            $table->string('cod_control')->unique();
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
        Schema::dropIfExists('compras');
    }
}
