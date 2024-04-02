<?php

namespace App\Services;

use DB;

class Query{

    //ok
    public function OBTEMTODOSUNIDADE(){
        $query = "SELECT id, nome, departamento, user_id, updated_at
        FROM unidades";
        $results = DB::select(DB::raw($query));
    }

    //ok
    public function RELAFICHAORCAMENTSDOINICIAL($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        $query = "SELECT D.descricaogrupo, (SUM(F.credito)) AS SDOINICIAL
        FROM dot_orcamentarias AS D
        INNER JOIN fic_orcamentarias AS F ON (D.id = F.dotacao_id)
        WHERE F.movimento_id = {$PCODIGOMOVIMENTO}
        AND UPPER(F.descricao) LIKE 'SALDO INICIAL%' AND D.grupo = $PGRUPO
        AND UPPER(D.receita) = UPPER($PRECEITA)
        GROUP BY descricaogrupo";
        $results = DB::select(DB::raw($query));
    }

    //ok
    public function RELAGASTOSUPLEMENTACAOREC($PCODIGOMOVIMENTO, $PRECEITA, $PGRUPO){
        $query = "SELECT FO.descricao, (SUM(FO.credito)) AS TOTALCREDITO,
        (SUM(FO.debito)) AS TOTALDEBITO
        FROM fic_orcamentarias AS FO
        INNER JOIN dot_orcamentarias AS D ON (FO.dotacao_id = D.id)
        WHERE FO.movimento_id = $PCODIGOMOVIMENTO
        AND UPPER(FO.descricao) LIKE 'SUPLEMENTA%'
        AND (UPPER(FO.descricao) NOT LIKE 'SUPLEMENTA% RECEITA%'
        AND UPPER(FO.descricao) NOT LIKE 'SUPLEMENTA% TRANSP%')
        AND UPPER(D.receita) = UPPER($PRECEITA) AND D.grupo = $PGRUPO
        GROUP BY FO.descricao
        ORDER BY FO.descricao";
        $results = DB::select(DB::raw($query));
    }

    //ok ?? rever inner join de lancamentos
    public function RELAGASTOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PRECEITA, $PGRUPO){
        $query = "SELECT C.nome, (SUM(L.credito)) AS TOTALCREDITO,
        (SUM(L.debito)) AS TOTALDEBITO
        FROM contas AS C
        INNER JOIN conta_lancamento AS CL ON (C.id = CL.conta_id)
        INNER JOIN lancamentos AS L ON (L.id = CL.lancamento_id)
        INNER JOIN tipo_contas AS T  ON (C.tipoconta_id = T.id)
        INNER JOIN fic_orcamentarias AS FO ON (L.ficorcamentaria_id = FO.id)
        INNER JOIN dot_orcamentarias AS D ON (FO.dotacao_id = D.id)
        WHERE FO.movimento_id = {$PCODIGOMOVIMENTO}
        AND UPPER(L.descricao) LIKE 'SUPLEMENTA%'
        AND UPPER(D.receita) = UPPER($PRECEITA) AND D.grupo = $PGRUPO
        AND UPPER(T.descricao) LIKE 'GASTO%'
        GROUP BY C.nome
        ORDER BY C.nome";
        $results = DB::select(DB::raw($query));
    }

    //ok
    public function RELAGASTONAOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PRECEITA, $PGRUPO){
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
        AND UPPER(D.receita) = UPPER($PRECEITA) AND D.grupo = $PGRUPO
        AND UPPER(T.descricao) LIKE 'GASTO%'
        GROUP BY C.nome
        ORDER BY C.nome";
        $results = DB::select(DB::raw($query));
    }

    //ok ?? rever inner join de lancamentos
    public function RELAPREVISAONAOVERBA($PCODIGOMOVIMENTO, $PRECEITA, $PGRUPO){
        $query = "SELECT C.nome, (SUM(L.credito)) AS TOTALCREDITO,
        (SUM(L.debito)) AS TOTALDEBITO
        FROM lancamentos AS L
        INNER JOIN conta_lancamento AS CL ON (L.id = CL.lancamento_id)
        INNER JOIN contas AS C ON (C.id = CL.conta_id)
        INNER JOIN tipo_contas AS T ON (C.tipoconta_id = T.id)
        WHERE L.movimento_id = {$PCODIGOMOVIMENTO}
        AND (UPPER(C.nome) NOT LIKE 'VERBA%' AND UPPER(C.nome) NOT LIKE 'CONTROLE%')
        AND (L.grupo = $PGRUPO) AND (L.receita = $PRECEITA)
        AND UPPER(T.descricao) LIKE 'PREVIS%'
        GROUP BY C.nome";
        $results = DB::select(DB::raw($query));
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
    */
    
    //ok ?? rever inner join de lancamentos
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
    }

    //ok ?? rever inner join de lancamentos
    public function RELARENDAINDUSTRIALADM($PCODIGOMOVIMENTO, $PRECEITA, $PGRUPO){
        $query = "SELECT C.nome, (SUM(L.credito)) AS TOTALCREDITO,
        (SUM(L.credito)) AS TOTALDEBITO
        FROM lancamentos AS L
        INNER JOIN conta_lancamento AS CL ON (L.id = CL.lancamento_id)
        INNER JOIN contas AS C ON (C.id = CL.conta_id)
        INNER JOIN tipo_contas AS T ON (C.tipoconta_id = T.id)
        WHERE L.movimento_id = {$PCODIGOMOVIMENTO}
        AND (L.grupo = $PGRUPO) AND (L.receita = $PRECEITA)
        AND UPPER(T.descricao) LIKE 'RENDA INDUSTRIAL - ADMINISTRA%'
        GROUP BY C.nome";
        $results = DB::select(DB::raw($query));
    }

}