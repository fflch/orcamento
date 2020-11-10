<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContaUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conta_usuarios', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('id_conta')->nullable();
            $table->foreign('id_conta')->references('id')->on('contas')->onDelete('set null');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conta_usuarios');
    }
}
