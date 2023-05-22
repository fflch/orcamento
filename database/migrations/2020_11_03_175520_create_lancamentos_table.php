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
            $table->unsignedBigInteger('movimento_id');
            $table->foreign('movimento_id')->references('id')->on('movimentos')->onDelete('cascade');
            $table->unsignedBigInteger('ficorcamentaria_id')->nullable();
            $table->foreign('ficorcamentaria_id')->references('id')->on('fic_orcamentarias')->onDelete('cascade');
            $table->string('grupo');
            $table->boolean('receita')->nullable()->default(FALSE);
            $table->date('data');
            $table->integer('empenho');
            $table->string('descricao');
            $table->float('debito', 15, 2)->nullable()->default(0.00);
            $table->float('credito', 15, 2)->nullable()->default(0.00);
            $table->float('saldo', 15, 2)->nullable()->default(0.00);
            $table->boolean('estornado')->nullable()->default(FALSE);
            $table->string('observacao');
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
        Schema::dropIfExists('lancamentos');
    }
}
