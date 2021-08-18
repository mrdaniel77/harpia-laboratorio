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
            $table->unsignedBigInteger('setor_id');
            $table->foreign('setor_id')->references('id')->on('setors');
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
