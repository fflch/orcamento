<?php

namespace App\Services;

use App\Models\Lancamento;
use App\Models\Conta;
use App\Models\ContaLancamento;
use DB;

class LancamentoService
{

    public static function saldo(int $movimento = null, int $conta = null, string $grupo = null, string $inicial = null, string $final = null) {
        $saldo = 0;

        $lancamentos = DB::table(
            'lancamentos'
        )->leftJoin(
            'conta_lancamento',
            'lancamentos.id', '=', 'conta_lancamento.lancamento_id'
        )->select(
            'lancamentos.id', 'lancamentos.data', 'lancamentos.observacao', 'lancamentos.descricao', 'lancamentos.grupo',
            'lancamentos.ficorcamentaria_id', 'lancamentos.receita', 'lancamentos.debito', 'lancamentos.credito', 'lancamentos.empenho',
            DB::Raw('((lancamentos.debito * conta_lancamento.percentual)/100) as valor_debito, ((lancamentos.credito * conta_lancamento.percentual)/100) as valor_credito')
        )->when($movimento, function($query, $movimento) {
                $query->whereRaw('lancamentos.movimento_id = ?', [$movimento]);
            }
        )->when($conta, function($query, $conta) {
                $query->whereRaw('conta_lancamento.conta_id = ?', [$conta]);
            }
        )->when($grupo, function($query, $grupo) {
                $query->whereRaw('lancamentos.grupo = ?', [$grupo]);
            }
        )->when($inicial && $final, function($query) use ($inicial, $final) {
                $query->whereRaw('lancamentos.data BETWEEN ? AND ?', [$inicial, $final]);
            }
        )->orderBy(
            'lancamentos.data', 'asc'
        )->get()
        ->map(function ($lancamento) use (&$saldo) {
           if(is_null($lancamento->valor_debito) && is_null($lancamento->valor_credito)) {
               $lancamento->valor_debito = $lancamento->debito;
               $lancamento->valor_credito = $lancamento->credito;
           }
           else {
               $lancamento->valor_debito = round($lancamento->valor_debito,2);
               $lancamento->valor_credito = round($lancamento->valor_credito,2);
           }
           $lancamento->data = implode('/',array_reverse(explode('-',$lancamento->data)));
           $saldo += $lancamento->valor_credito - $lancamento->valor_debito;
           $lancamento->saldo = $saldo;

           return $lancamento;
        });

        return $lancamentos;
    }

}
