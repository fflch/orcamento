<?php

namespace App\Services;

use App\Models\Lancamento;
use App\Models\Conta;
use App\Models\ContaLancamento;
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
    public static function manipulaLancamentos($lancamentos, $lancamentos_fake, $conta_id = null){
        $total_debito  = 0.00;
        $total_credito = 0.00;
        $saldo_auxiliar = 0;

        foreach($lancamentos as $lancamento){
            $pivots = ContaLancamento::where('lancamento_id',$lancamento->id)->get();

            if($pivots->isNotEmpty()) {
            
                // Se tem relação na tabela conta_lancamento, vamos ter que duplicar, triplicar etc os lançamentos
                foreach($pivots as $pivot){
                    $new = $lancamento->replicate();
                    $new->id = $lancamento->id;

                    $new->conta = Conta::find($pivot->conta_id);

                    // Se tiver filtro por conta
                    if($conta_id != null and $conta_id!=$new->conta->id) continue;
 
                    if($new->debito != 0.00) {
                        $new->debito = (float) ($new->debito_raw * $pivot->percentual/100);
                    }
                    if($new->credito != 0.00) {
                        $new->credito = (float)($new->credito_raw * $pivot->percentual/100);
                    }
    
                    $total_debito = $total_debito + (float)$new->debito_raw ;
                    $total_credito = $total_credito + (float)$new->credito_raw;
    
                    $saldo_auxiliar = $saldo_auxiliar + ((float)$new->credito_raw - (float)$new->debito_raw);
                    $new->saldo_valor = $saldo_auxiliar;

                    $lancamentos_fake->push($new);
                }

            } else {
                $total_debito = $total_debito + $lancamento->debito_raw;
                $total_credito = $total_credito + $lancamento->credito_raw;

                $saldo_auxiliar = $saldo_auxiliar + ($lancamento->credito_raw - $lancamento->debito_raw);
                $lancamento->saldo_valor = $saldo_auxiliar;

                // Se tem filtro de conta
                if($conta_id != null) {
                    $lancamento->conta = Conta::find($conta_id);
                }

                $lancamentos_fake->push($lancamento);
            }
        }
        return [
            'total_debito' => $total_debito, 
            'total_credito' => $total_credito
        ];
    }

}
