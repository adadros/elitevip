<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('uid');
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('email');
            $table->string('telefono')->nullable();
             $table->string('estado')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('cp')->nullable();
            $table->string('rfc')->nullable();
            $table->string('ocupacion')->nullable();
            $table->string('paises_favoritos')->nullable();
            $table->string('hoteles_favoritos')->nullable();
            $table->string('dj_favorito')->nullable();
            $table->string('tipo_musica')->nullable();
            $table->string('hobbies')->nullable();
            $table->string('redes_sociales')->nullable();
            $table->string('foto')->nullable();
            $table->foreign('uid')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('perfil');
    }
}
