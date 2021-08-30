<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFicOrcamentariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fic_orcamentarias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('movimento_id')->nullable();
            $table->foreign('movimento_id')->references('id')->on('movimentos')->onDelete('set null');
            $table->unsignedBigInteger('dotacao_id')->nullable();
            $table->foreign('dotacao_id')->references('id')->on('dot_orcamentarias')->onDelete('set null');
            $table->date('data');
            $table->integer('empenho');
            $table->string('descricao', 150);
            $table->float('debito', 15, 2);
            $table->float('credito', 15, 2);
            $table->float('saldo', 15, 2)->nullable();
            $table->string('observacao', 150);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('fic_orcamentarias');
    }
}
