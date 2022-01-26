<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDotOrcamentariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dot_orcamentarias', function (Blueprint $table) {
            $table->id();
            $table->integer('dotacao')->unique();
            $table->string('grupo');
            $table->string('descricaogrupo');
            $table->integer('item');
            $table->string('descricaoitem');
            $table->boolean('receita')->nullable()->default(FALSE);
            $table->boolean('ativo')->nullable()->default(FALSE);
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
        Schema::dropIfExists('dot_orcamentarias');
    }
}
