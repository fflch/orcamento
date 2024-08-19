<?php

namespace App\Services;
use App\Models\Lancamento;
use App\Models\Conta;

use App\Services\LancamentoService;

use DB;

class Query{

    //não usada
    public function OBTEMTODOSUNIDADE(){
        $query = "SELECT id, nome, departamento, user_id, updated_at
        FROM unidades";
        $results = DB::select(DB::raw($query));
    }

    //Pega lançamento cadastrado como Saldo Inicial/crédito - parte de cima do PDF
    public function RELAFICHAORCAMENTSDOINICIAL($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        if($PRECEITA == null){
            $PRECEITA = 0;
        }
        $query = "SELECT D.descricaogrupo, (SUM(F.credito)) AS SDOINICIAL
        FROM dot_orcamentarias AS D
        INNER JOIN fic_orcamentarias AS F ON (D.id = F.dotacao_id)
        WHERE F.movimento_id = {$PCODIGOMOVIMENTO}
        AND UPPER(F.descricao) LIKE 'SALDO INICIAL%' 
        AND D.grupo = {$PGRUPO}
        AND D.receita = {$PRECEITA}
        GROUP BY D.descricaogrupo";
        $results = DB::select(DB::raw($query));
        return $results;
    }

    //Pega suplementação que é cadastrada como gasto efetivo, mas entendida como crédito - parte de cima do PDF
    public function RELAGASTOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        // FALTA CONFERIR NA VIEW SE AS PORCENTAGENS DE CONTA_LANCAMENTO ESTÃO SENDO APLICADAS 
        if ($PRECEITA ?? 0){
            $query = "SELECT FO.descricao, (SUM(FO.credito)) AS TOTALCREDITO,
            (SUM(FO.debito)) AS TOTALDEBITO
            FROM fic_orcamentarias AS FO
            INNER JOIN dot_orcamentarias AS D ON (FO.dotacao_id = D.id)
            WHERE FO.movimento_id = {$PCODIGOMOVIMENTO}
            AND UPPER(FO.descricao) LIKE 'SUPLEMENTA%'
            AND UPPER(FO.descricao) NOT LIKE 'SUPLEMENTA% RECEITA%'
            AND UPPER(FO.descricao) NOT LIKE 'SUPLEMENTA% TRANSP%'
            AND D.grupo = {$PGRUPO}
            AND D.receita = 1
            GROUP BY FO.descricao";
            
        }
        else{

            $query = "SELECT C.nome as descricao, (SUM(L.credito)) AS TOTALCREDITO,
            (SUM(L.debito)) AS TOTALDEBITO
            FROM contas AS C
            INNER JOIN conta_lancamento AS CL ON (C.id = CL.conta_id)
            INNER JOIN lancamentos AS L ON (L.id = CL.lancamento_id)
            INNER JOIN tipo_contas AS T  ON (C.tipoconta_id = T.id)
            INNER JOIN fic_orcamentarias AS FO ON (L.ficorcamentaria_id = FO.id)
            INNER JOIN dot_orcamentarias AS D ON (FO.dotacao_id = D.id)
            WHERE FO.movimento_id = {$PCODIGOMOVIMENTO}
            AND UPPER(L.descricao) LIKE 'SUPLEMENTA%'
            AND D.grupo = {$PGRUPO}
            AND D.receita = 0
            AND UPPER(T.descricao) LIKE 'GASTO%'
            GROUP BY descricao
            ORDER BY descricao";
        }
        return DB::select(DB::raw($query));
    }

    public function RELAGASTONAOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA, $PERIODO){

        // Vamos pegar os id's das contas que contém lançamentos no grupo e movimento selecionados
        $contas_ids = Lancamento::where('grupo',$PGRUPO)
            ->where('lancamentos.descricao', 'NOT LIKE', '%SUPLEMENTA%')
            // join para pegar as contas 
            ->join('conta_lancamento', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            // join para pegar o tipo de conta e portanto a descrição
            ->join('contas', 'conta_lancamento.conta_id', '=', 'contas.id')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->where('tipo_contas.descricao', 'LIKE', 'GASTO%')
            ->where('lancamentos.movimento_id', '=', $PCODIGOMOVIMENTO)
            ->orderBy('contas.nome', 'ASC')
            ->pluck('conta_id') // só queremos os IDs das contas
            ->toArray();

        $contas_ids = array_unique($contas_ids);

        $table = [];
        foreach($contas_ids as $conta_id){

            $conta = Conta::find($conta_id);

            $lancamentos_nesta_conta = Lancamento::where('grupo',$PGRUPO)
                        ->where('data', '<=', $PERIODO)
                        ->where('movimento_id', '=', $PCODIGOMOVIMENTO)
                        ->join('conta_lancamento', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
                        ->where('conta_id', $conta_id)
                        ->select('debito','credito', 'receita')->get();
            
            if($PRECEITA != null){
                $lancamentos_nesta_conta = $lancamentos_nesta_conta->where('receita', 1);
            } else {
                $lancamentos_nesta_conta = $lancamentos_nesta_conta->where('receita', 0);
            }           

            // Calcula débitos
            $debitos = [];
            foreach($lancamentos_nesta_conta as $lancamento){
                $debitos[] = (float) str_replace(',','.',$lancamento->debito);
            }

            // Calcula crédito
            $creditos = [];
            foreach($lancamentos_nesta_conta as $lancamento){
                $creditos[] = (float) str_replace(',','.',$lancamento->credito);
            }

            $saldo = array_sum($debitos) - array_sum($creditos);
            if($saldo > 0){
                $table[] = [
                    'nome_conta' => $conta->nome,
                    'saldo'      => $saldo
                ];            
            }
        }

        // Ordenando $table em ordem alfabética
        return $table;
    }

    /*
    //Pega as contas de gasto efetivo/débito - parte de baixo do PDF
    //ainda não usada
    public function RELAGASTONAOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        if($PRECEITA == null){
            $PRECEITA = 0;
        }
        $query = "SELECT 
            (SUM(L.credito)) AS TOTALCREDITO,
            (SUM(L.debito)) AS TOTALDEBITO
        FROM lancamentos AS L 
        INNER JOIN conta_lancamento AS CL ON (L.id = CL.lancamento_id)
        INNER JOIN contas AS C ON (C.id = CL.conta_id)
        INNER JOIN tipo_contas AS T  ON (C.tipoconta_id = T.id)
        INNER JOIN fic_orcamentarias AS FO ON (L.ficorcamentaria_id = FO.id)
        INNER JOIN dot_orcamentarias AS D ON (FO.dotacao_id = D.id)
        WHERE FO.movimento_id = {$PCODIGOMOVIMENTO}
        AND UPPER(L.descricao) NOT LIKE '%SUPLEMENTA%'
        AND D.receita = $PRECEITA 
        AND D.grupo = $PGRUPO
        AND UPPER(T.descricao) LIKE 'GASTO%'
        GROUP BY C.nome
        ORDER BY C.nome";
        $results = DB::select(DB::raw($query));
        return $results;
    }
    */

    //Pega as contas vinculadas ao tipo de conta Previsão da Administração, no relatório Orçamento
    public function RELAPREVISAONAOVERBA($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        if($PRECEITA == null){
            $PRECEITA = 0;
        }
        $query = "SELECT C.nome, (SUM(L.credito)) AS TOTALCREDITO,
        (SUM(L.debito)) AS TOTALDEBITO
        FROM lancamentos AS L
        INNER JOIN conta_lancamento AS CL ON (L.id = CL.lancamento_id)
        INNER JOIN contas AS C ON (C.id = CL.conta_id)
        INNER JOIN tipo_contas AS T ON (C.tipoconta_id = T.id)
        WHERE L.movimento_id = {$PCODIGOMOVIMENTO}
        AND (UPPER(C.nome) NOT LIKE 'VERBA%' 
        AND UPPER(C.nome) NOT LIKE 'CONTROLE%')
        AND L.grupo = {$PGRUPO}
        AND L.receita = {$PRECEITA}
        AND UPPER(T.descricao) LIKE 'PREVIS%'
        GROUP BY C.nome";
        $results = DB::select(DB::raw($query));
        return $results;
    }

    //acho que não é mais usado
    /*
    public function RELAPREVISAOMATCONSUMO(){
        $query = "SELECT DISTINCT A.NOME, (SUM(L.CREDITO)) AS TOTALCREDITO,
        (SUM(L.DEBITO)) AS TOTALDEBITO, SA.SALDOCONSUMO
        FROM LANCAMENTOS L
        INNER JOIN CONTAS      C ON (L.CODIGOCONTA = C.CODIGO)
        INNER JOIN TIPOSCONTAS T ON (C.CODIGOTIPOCONTA = T.CODIGO)
        INNER JOIN SALDOAREAS SA ON (C.CODIGOAREA = SA.CODIGOAREA)
        RIGHT JOIN AREAS       A ON (SA.CODIGOAREA = A.CODIGO)
        WHERE SA.CODIGOMOVIMENTO = :PCODIGOMOVIMENTO
        AND L.CODIGOMOVIMENTO = :PCODIGOMOVIMENTO
        AND ((L.DESCRICAO LIKE '%' || 'Almoxarifado' || '%')
        OR (L.DESCRICAO LIKE '%' || 'Miúdas' || '%')
        OR (UPPER(L.DESCRICAO) LIKE '%' || 'SUPLEMENTA' || '%'))
        AND UPPER(T.DESCRICAO) LIKE 'AREAS/S%'
        GROUP BY A.NOME, SA.SALDOCONSUMO";
        $results = DB::select(DB::raw($query));
    }
    
    //Pega as contas vinculadas ao tipo de conta Previsão da Administração, no relatório Orçamento
    //ainda não usada - usada para fazer a parte que o setor quer eliminar (saldo orçamentário)
    public function RELAPREVISAOVERBA($PCODIGOMOVIMENTO, $PRECEITA, $PGRUPO){
        $query = "SELECT C.nome, (SUM(L.credito)) AS TOTALCREDITO,
        (SUM(L.debito)) AS TOTALDEBITO
        FROM lancamentos AS L
        INNER JOIN conta_lancamento AS CL ON (L.id = CL.lancamento_id)
        INNER JOIN contas AS C ON (C.id = CL.conta_id)
        INNER JOIN tipo_contas AS T ON (C.tipoconta_id = T.id)
        WHERE L.movimento_id = {$PCODIGOMOVIMENTO}
        AND (UPPER(C.nome) LIKE 'VERBA%'OR UPPER(C.nome) LIKE 'CONTROLE%')
        AND (L.grupo = $PGRUPO) AND (L.receita = $PRECEITA)
        AND UPPER(T.descricao) LIKE 'PREVIS%'
        GROUP BY C.nome";
        $results = DB::select(DB::raw($query));
        return $results;
    }
    */

    //Pega as contas vinculadas ao tipo de conta Administração, no relatório de Renda Industrial
    public function RELARENDAINDUSTRIALADM($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        if($PRECEITA == null){
            $PRECEITA = 0;
        }
        $query = "SELECT C.nome, (SUM(L.credito)) AS TOTALCREDITO,
        (SUM(L.credito)) AS TOTALDEBITO
        FROM lancamentos AS L
        INNER JOIN conta_lancamento AS CL ON (L.id = CL.lancamento_id)
        INNER JOIN contas AS C ON (C.id = CL.conta_id)
        INNER JOIN tipo_contas AS T ON (C.tipoconta_id = T.id)
        WHERE L.movimento_id = {$PCODIGOMOVIMENTO}
        AND (L.grupo = $PGRUPO) 
        AND (L.receita = $PRECEITA)
        AND UPPER(T.descricao) LIKE 'RENDA INDUSTRIAL - ADMINISTRA%'
        GROUP BY C.nome";
        $results = DB::select(DB::raw($query));
        return $results;
    }

}