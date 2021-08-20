<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtribuicoesLidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atribuicoes_liders', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('lider_id');
            $table->foreign('lider_id')->references('id')->on('plano_auditorias');
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
        Schema::dropIfExists('atribuicoes_liders');
    }
}
