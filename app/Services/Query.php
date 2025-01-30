<?php

namespace App\Services;
use App\Models\Lancamento;
use App\Models\Conta;
use App\Models\TipoConta;
use App\Services\LancamentoService;

use DB;

class Query{

    //não usada
    public static function OBTEMTODOSUNIDADE(){
        $query = "SELECT id, nome, departamento, user_id, updated_at
        FROM unidades";
        $results = DB::select($query);
    }

    //Pega lançamento cadastrado como Saldo Inicial/crédito - parte de cima do PDF
    public static function RELAFICHAORCAMENTSDOINICIAL($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        $query = "SELECT d.descricaogrupo, (SUM(f.credito)) AS saldoinicial
        FROM dot_orcamentarias AS d
        INNER JOIN fic_orcamentarias AS f ON (d.id = f.dotacao_id)
        WHERE f.movimento_id = {$PCODIGOMOVIMENTO}
        AND UPPER(f.descricao) LIKE 'SALDO INICIAL%'
        AND d.grupo = {$PGRUPO}
        AND d.receita = '{$PRECEITA}'
        GROUP BY d.descricaogrupo";
        return DB::select($query);
    }

    //Pega suplementação que é cadastrada como gasto efetivo, mas entendida como crédito - parte de cima do PDF
    public static function RELAGASTOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        // FALTA CONFERIR NA VIEW SE AS PORCENTAGENS DE CONTA_LANCAMENTO ESTÃO SENDO APLICADAS
        if ($PRECEITA ?? 0){
            $query = "SELECT fo.descricao, ((SUM(fo.credito)) - (SUM(fo.debito))) AS total
            FROM fic_orcamentarias AS fo
            INNER JOIN dot_orcamentarias AS d ON (fo.dotacao_id = d.id)
            WHERE fo.movimento_id = {$PCODIGOMOVIMENTO}
            AND UPPER(fo.descricao) LIKE 'SUPLEMENTA%'
            AND UPPER(fo.descricao) NOT LIKE 'SUPLEMENTA% RECEITA%'
            AND UPPER(fo.descricao) NOT LIKE 'SUPLEMENTA% TRANSP%'
            AND d.grupo = {$PGRUPO}
            AND d.receita = 1
            GROUP BY fo.descricao";
        }
        else{
            $query = "SELECT c.nome as descricao, ((SUM(fo.credito)) - (SUM(fo.debito))) AS total
            FROM contas AS c
            INNER JOIN conta_lancamento AS cl ON (c.id = cl.conta_id)
            INNER JOIN lancamentos AS l ON (l.id = cl.lancamento_id)
            INNER JOIN tipo_contas AS t  ON (c.tipoconta_id = t.id)
            INNER JOIN fic_orcamentarias AS fo ON (l.ficorcamentaria_id = fo.id)
            INNER JOIN dot_orcamentarias AS d ON (fo.dotacao_id = d.id)
            WHERE fo.movimento_id = {$PCODIGOMOVIMENTO}
            AND UPPER(l.descricao) LIKE 'SUPLEMENTA%'
            AND d.grupo = {$PGRUPO}
            AND d.receita = 0
            AND UPPER(t.descricao) LIKE 'GASTO%'
            GROUP BY descricao
            ORDER BY descricao";
        }
        return DB::select($query);
    }

    public static function RELAGASTONAOSUPLEMENTACAO($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA, $PERIODO){
        $query = "SELECT co.nome, ((sum(l.debito)) - (sum(l.credito))) AS total FROM lancamentos l
                  INNER JOIN conta_lancamento c ON (c.lancamento_id = l.id)
                  INNER JOIN contas co ON (co.id = c.conta_id)
                  INNER JOIN tipo_contas t on (co.tipoconta_id = t.id)
                  INNER JOIN fic_orcamentarias f on (f.id = l.ficorcamentaria_id)
                  INNER JOIN dot_orcamentarias d on (d.id = f.dotacao_id)
                  WHERE UPPER(l.descricao) NOT LIKE '%SUPLEMENTA%' AND f.movimento_id = {$PCODIGOMOVIMENTO}
                  AND d.grupo = '{$PGRUPO}' AND UPPER(t.descricao) LIKE 'GASTO%' AND d.receita = '{$PRECEITA}'
                  GROUP BY co.nome
                  ORDER BY co.nome";
        return DB::select($query);
    }

    //Pega as contas vinculadas ao tipo de conta Previsão da Administração, no relatório Orçamento
    public static function RELAPREVISAONAOVERBA($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        $query = "SELECT c.nome, ((SUM(l.credito)) - (SUM(l.debito))) AS total
        FROM lancamentos AS l
        INNER JOIN conta_lancamento AS cl ON (l.id = cl.lancamento_id)
        INNER JOIN contas AS c ON (c.id = cl.conta_id)
        INNER JOIN tipo_contas AS t ON (c.tipoconta_id = t.id)
        WHERE l.movimento_id = {$PCODIGOMOVIMENTO}
        AND (UPPER(c.nome) NOT LIKE 'VERBA%'
        AND UPPER(c.nome) NOT LIKE 'CONTROLE%')
        AND l.grupo = '{$PGRUPO}'
        AND l.receita = '{$PRECEITA}'
        AND UPPER(t.descricao) LIKE 'PREVIS%'
        GROUP BY c.nome";
        return DB::select($query);
    }

    //acho que não é mais usado
    /*
    public function RELAPREVISAOMATCONSUMO(){
        $query = "SELECT DISTINCT A.NOME, (SUM(L.CREDITO)) AS totalCREDITO,
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
    public static function RELARENDAINDUSTRIALADM($PCODIGOMOVIMENTO, $PGRUPO, $PRECEITA){
        $query = "SELECT c.nome, ((SUM(l.credito)) - (SUM(l.debito))) AS total
        FROM lancamentos AS l
        INNER JOIN conta_lancamento AS cl ON (l.id = cl.lancamento_id)
        INNER JOIN contas AS c ON (c.id = cl.conta_id)
        INNER JOIN tipo_contas AS t ON (c.tipoconta_id = t.id)
        WHERE l.movimento_id = {$PCODIGOMOVIMENTO}
        AND (l.grupo = '{$PGRUPO}')
        AND (l.receita = '{$PRECEITA}')
        AND UPPER(t.descricao) LIKE 'RENDA INDUSTRIAL - ADMINISTRA%'
        GROUP BY c.nome";
        return DB::select($query);
    }

    public static function SaldoProjetosEspeciais(int $ano_id) {
        $tipoconta = TipoConta::select('id')
            ->where('descricao','PROJETOS ESPECIAIS')->first();

        $query = "SELECT l.grupo, c.id, c.nome, tc.descricao, (SUM(l.credito) - SUM(l.debito)) as total
            from contas c inner join tipo_contas tc on (c.tipoconta_id = tc.id)
            INNER JOIN conta_lancamento cl on (cl.conta_id = c.id)
            INNER JOIN lancamentos l on (l.id = cl.lancamento_id)
            WHERE c.tipoconta_id = {$tipoconta->id} AND l.movimento_id = {$ano_id}
            GROUP BY c.nome, c.id, tc.descricao, l.grupo
            HAVING (SUM(l.credito) - SUM(l.debito)) <> 0";

        return DB::select($query);
    }
}
