<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanoAuditoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plano_auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('referencia')->nullable();
            $table->unsignedBigInteger('setor_organizacao');
            $table->foreign('setor_organizacao')->references('id')->on('setors');
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->string('avaliacao')->nullable();
            $table->string('doc_base')->nullable();
            $table->string('requisitos')->nullable();
            $table->text('objetivo')->nullable();
            $table->text('abg_programa')->nullable();
            $table->text('riscos')->nullable();
            $table->string('data_abertura')->nullable();
            $table->string('data_encerramento')->nullable();
            $table->text('relato')->nullable();
            $table->text('metodo')->nullable();
            $table->unsignedBigInteger('avaliador_lider');
            $table->foreign('avaliador_lider')->references('id')->on('colaboradors');
            $table->text('avaliador_especialista')->nullable();
            $table->text('setor_avaliador')->nullable();
            $table->string('item')->nullable();
            $table->string('matriz')->nullable();
            $table->string('ensaio')->nullable();
            $table->string('metodo_escopo')->nullable();
            $table->unsignedBigInteger('setor_escopo');
            $table->foreign('setor_escopo')->references('id')->on('setors');
            $table->string('data_plano')->nullable();
            $table->string('atividade')->nullable();
            $table->string('processo')->nullable();
            $table->string('item_plano')->nullable();
            $table->string('itens_normativos')->nullable();
            $table->text('auditores')->nullable();
            $table->unsignedBigInteger('auditor_lider_plano');
            $table->foreign('auditor_lider_plano')->references('id')->on('colaboradors');
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
        Schema::dropIfExists('plano_auditorias');
    }
}
