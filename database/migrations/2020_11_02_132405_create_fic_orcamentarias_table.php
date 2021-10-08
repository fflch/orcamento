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
            $table->unsignedBigInteger('movimento_id');
            $table->foreign('movimento_id')->references('id')->on('movimentos')->onDelete('cascade');
            $table->unsignedBigInteger('dotacao_id');
            $table->foreign('dotacao_id')->references('id')->on('dot_orcamentarias')->onDelete('cascade');
            $table->date('data');
            $table->integer('empenho');
            $table->string('descricao', 150);
            $table->float('debito', 15, 2)->nullable()->default(0.00);
            $table->float('credito', 15, 2)->nullable()->default(0.00);
            $table->float('saldo', 15, 2)->nullable()->default(0.00);
            $table->string('observacao', 150);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
