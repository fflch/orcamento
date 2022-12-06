<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaLancamentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_lancamento', function (Blueprint $table) {
            //$table->id();
            $table->timestamps();

            $table->unsignedBigInteger('conta_id');
            $table->foreign('conta_id')->references('id')
                  ->on('contas')->onDelete('cascade');

            $table->unsignedBigInteger('lancamento_id');
            $table->foreign('lancamento_id')->references('id')
                    ->on('lancamentos')->onDelete('cascade');
                    
            $table->integer('percentual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_lancamento');
    }
}
