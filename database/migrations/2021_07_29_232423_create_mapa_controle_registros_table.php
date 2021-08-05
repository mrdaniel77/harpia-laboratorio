<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMapaControleRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapa_controle_registros', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 20);
            $table->string('nome', 255)->nullable();
            $table->string('acesso', 100);
            $table->string('coleta', 100);
            $table->string('armazenamento', 100)->nullable();
            $table->enum('indexacao', ['Alfabética', 'Cronológica'])->nullable();
            $table->string('tempo_retencao', 100)->nullable();
            $table->enum('descarte', ['Picotar', 'Deletar'])->nullable();
            $table->string('responsavel', 255);
            $table->date('data', 10);
            $table->string('outro', 100);
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
        Schema::dropIfExists('mapa_controle_registros');
    }
}
