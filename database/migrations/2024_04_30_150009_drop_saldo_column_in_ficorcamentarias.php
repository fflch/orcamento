<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSaldoColumnInFicorcamentarias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fic_orcamentarias', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fic_orcamentarias', function (Blueprint $table) {
            $table->float('saldo', 15, 2)->nullable()->default(0.00);
        });
    }
}
