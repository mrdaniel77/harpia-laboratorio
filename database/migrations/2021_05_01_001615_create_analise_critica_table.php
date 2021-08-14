<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnaliseCriticaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analise_critica', function (Blueprint $table) {
            $table->id();
            $table->enum('metodos_definidos', ['Sim', 'Não']);
            $table->enum('pessoal_qualificado', ['Sim', 'Não']);
            $table->enum('capacidade_recursos', ['Sim', 'Não']);
            $table->enum('metodo_ensaio', ['Sim', 'Não']);
            $table->enum('aprovado', ['Sim', 'Não']);
            $table->text('justificativa_reprovacao')->nullable();
            $table->bigInteger('colaborador_id');
            $table->date('data');
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
        Schema::dropIfExists('analise_critica');
    }
}
