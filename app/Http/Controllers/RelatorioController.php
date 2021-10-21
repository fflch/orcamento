<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lancamento;
use App\Models\FicOrcamentaria;

use App\Models\Conta;
use App\Models\TipoConta;

use App\Models\DotOrcamentaria;
use App\Models\Nota;
use App\Models\Area;


use PDF;

class RelatorioController extends Controller
{
    public function relatorios(){
        $this->authorize('Todos');
        $lista_contas      = Conta::lista_contas();
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias();
        $lista_descricoes  = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();
        $lista_areas = Area::lista_areas();

        return view('relatorios.index', compact('lista_contas',
                                                'lista_dotorcamentarias',
                                                'lista_descricoes',
                                                'lista_observacoes',
                                                'lista_areas'));
    }


    public function balancete(Request $request){
        if($request->data != null){
            $tiposconta = TipoConta::All();
            dd($tiposconta->user->name);
            $balancete = Conta::All();
            $periodo = $request->data;
        }

        $pdf = PDF::loadView('pdfs.balancete', [
            'balancete'    => $balancete,
            'periodo'    => $periodo,

        ])->setPaper('a4', 'landscape');
        return $pdf->download("balancete.pdf");
    }

    public function lancamentos(Request $request){
        //if($request->data != null){
            $lancamentos = Lancamento::All();
        //}

        $pdf = PDF::loadView('pdfs.lancamentos', [
            'lancamentos'    => $lancamentos,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("lancamentos.pdf");
    }

    public function ficha_orcamentaria(Request $request){
        //if($request->data != null){
            $ficha_orcamentaria = FicOrcamentaria::All();
        //}

        $pdf = PDF::loadView('pdfs.ficha_orcamentaria', [
            'ficha_orcamentaria'    => $ficha_orcamentaria,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("ficha_orcamentaria.pdf");
    }

    public function saldo_contas(Request $request){
        //if($request->data != null){
            $saldo_contas = Conta::All();
        //}

        $pdf = PDF::loadView('pdfs.saldo_contas', [
            'saldo_contas'    => $saldo_contas,
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_contas.pdf");
    }

    public function saldo_dotacoes(Request $request){
        //if($request->data != null){
            $saldo_dotacoes = DotOrcamentaria::All();
        //}

        $pdf = PDF::loadView('pdfs.saldo_dotacoes', [
            'saldo_dotacoes'    => $saldo_dotacoes,
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_dotacoes.pdf");
    }

}
