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
            $table->integer('dotacao');
            $table->string('grupo', 4);
            $table->string('descricaogrupo', 100);
            $table->integer('item');
            $table->string('descricaoitem', 100);
            $table->boolean('receita')->nullable();
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
