<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLancamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lancamentos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('grupo', 4);
            $table->boolean('receita')->nullable();
            $table->date('data');
            $table->integer('empenho');
            $table->string('descricao', 100);
            $table->double('debito', 15, 2);
            $table->double('credito', 15, 2);
            $table->string('observacao', 100);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('movimento_id')->nullable();
            $table->foreign('movimento_id')->references('id')->on('movimentos')->onDelete('set null');
            $table->unsignedBigInteger('conta_id')->nullable();
            $table->foreign('conta_id')->references('id')->on('contas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lancamentos');
    }
}
