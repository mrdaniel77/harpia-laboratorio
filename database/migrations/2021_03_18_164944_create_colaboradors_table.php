<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColaboradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradors', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('email', 100);
            $table->string('cpf', 14);
            $table->string('telefone', 15);
            $table->string('cep', 9)->nullable();
            $table->string('logradouro', 255)->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro', 150)->nullable();
            $table->string('complemento', 255)->nullable();
            $table->string('cidade', 150)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('formacao')->nullable();
            $table->string('funcao')->nullable();
            $table->text('foto')->nullable();
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
        Schema::dropIfExists('colaboradors');
    }
}
