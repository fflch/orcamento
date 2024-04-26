<?php

namespace App\Services;

class FicOrcamentariaService
{
    /**
     * Essa função não apresenta nenhum efeito colateral no banco de dados, pois nada é salvo.
     * Ela faz duas coisas:
     * 1. dado uma coleção de objetos $fichas, para cada $ficha adicionamos uma
     * variáveis temporária chamada de saldo_valor para facilicar a exibição nas views, seja pdf ou html
     * 2. retorna $total_debito e $total_credito
     */
    public static function handle($fichas){
        $total_debito  = 0.00;
        $total_credito = 0.00;
        $saldo_auxiliar = 0;

        foreach($fichas as $index=>$ficha){                
                $total_debito = $total_debito + $ficha->debito_raw;
                $total_credito = $total_credito + $ficha->credito_raw;

                $saldo_auxiliar = $saldo_auxiliar + ($ficha->credito_raw - $ficha->debito_raw);
                $ficha->saldo_valor = $saldo_auxiliar;
            }
        return [
            'total_debito' => $total_debito, 
            'total_credito' => $total_credito
        ];
    }
}