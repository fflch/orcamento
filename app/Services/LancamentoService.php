<?php

namespace App\Services;

use App\Models\Lancamento;

class LancamentoService
{
    /**
     * Register services.
     *
     * @return void
     */
    public function handle($inicial, $final, $conta)
    {
        $lancamentos = Lancamento::whereHas('contas', function ($query) use ($conta) {
            $query->where('conta_id', $conta);
        })
        ->whereBetween('data', [$inicial, $final])
        ->get();

        return $lancamentos;
    }

}
