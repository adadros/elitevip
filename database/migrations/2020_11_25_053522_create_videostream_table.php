<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideostreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_stream', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('calidad')->nullable();
            $table->string('bitrate')->nullable();
            $table->string('resolucion')->nullable();
            $table->string('formato')->nullable();
            $table->string('duracion')->nullable();
            $table->boolean('live')->default(false);
            $table->integer('reproducciones')->nullable()->default(0);
            $table->integer('conexiones')->nullable()->default(0);
            $table->integer('likes')->nullable()->default(0);
            $table->boolean('privado');
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
        Schema::dropIfExists('video_stream');
    }
}
