<?php

namespace App\Services;

use App\Models\Lancamento;
use App\Models\Conta;
use DB;

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

    /**
     * Essa função não apresenta nenhum efeito colateral no banco de dados, pois nada é salvo.
     * Ela faz duas coisas:
     * 1. dado uma coleção de objetos $lancamentos, para cada $lancamento adicionamos uma
     * variáveis temporária chamada de saldo_valor para facilicar a exibição nas views, seja pdf ou html
     * 2. retorna $total_debito e $total_credito
     */
    public static function manipulaLancamentos($lancamentos, $conta_id = null){
        $total_debito  = 0.00;
        $total_credito = 0.00;
        $saldo_auxiliar = 0;

        foreach($lancamentos as $index=>$lancamento){                
            // Se tem conta_id, temos que verificar a relação!
            if($conta_id){
                $lancamento->conta = Conta::find($conta_id);

                $relation = DB::table('conta_lancamento')
                                ->where('lancamento_id',$lancamento->id)
                                ->where('conta_id',$conta_id)
                                ->first();
                
                if($relation != null){
                    $debito_float = (float)$lancamento->debito_raw * $relation->percentual/100;
                    $credito_float = (float)$lancamento->credito_raw * $relation->percentual/100;

                    $total_debito = $total_debito + $debito_float;
                    $total_credito = $total_credito + $credito_float;

                    $saldo_auxiliar = $saldo_auxiliar + ($credito_float - $debito_float);
                    $lancamento->saldo_valor = $saldo_auxiliar;

                }
            } else {
                $total_debito = $total_debito + $lancamento->debito_raw;
                $total_credito = $total_credito + $lancamento->credito_raw;

                $saldo_auxiliar = $saldo_auxiliar + ($lancamento->credito_raw - $lancamento->debito_raw);
                $lancamento->saldo_valor = $saldo_auxiliar;
            }
        }
        return [
            'total_debito' => $total_debito, 
            'total_credito' => $total_credito
        ];
    }

}
