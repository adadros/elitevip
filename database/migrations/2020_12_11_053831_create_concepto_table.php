<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pago');
            $table->unsignedBigInteger('ticket');
            $table->unsignedBigInteger('evento');
            $table->foreign('pago')->references('id')->on('pagos');
            $table->foreign('ticket')->references('id')->on('tickets');
            $table->foreign('evento')->references('id')->on('evento');
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
        Schema::dropIfExists('concepto');
    }
}
