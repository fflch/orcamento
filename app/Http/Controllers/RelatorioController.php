<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimento;
use App\Models\Lancamento;
use App\Models\FicOrcamentaria;
use App\Models\Conta;
use App\Models\TipoConta;
use App\Models\DotOrcamentaria;
use App\Models\Nota;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use App\Services\LancamentoService;
use App\Services\FormataDataService;

class RelatorioController extends Controller
{
    public function relatorios(){
        $this->authorize('Todos');
        return view('relatorios.index', [
                    'movimento_anos'  => Movimento::movimento_anos(),
                    'movimento_ativo'        => Movimento::movimento_ativo(),
                    'lista_tipos_contas'     => TipoConta::lista_tipos_contas(),
                    'lista_contas_ativas'    => Conta::lista_contas_ativas(),
                    'lista_dotorcamentarias' => DotOrcamentaria::lista_dotorcamentarias_ativas(),
                    'lista_descricoes'       => Nota::lista_descricoes(),
                    'lista_observacoes'      => Nota::lista_observacoes()
        ]);
    }

    public function balancete(Request $request){
        if($request->data != null){
            $periodo = $request->data;
            $data_convertida = implode("-", array_reverse(explode("/", $request->data)));
            $balanceteO = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->select('contas.nome', 'tipo_contas.descricao',
            DB::raw('SUM(lancamentos.debito) as total_debito'), 
            DB::raw('SUM(lancamentos.credito) as total_credito'))
            ->where('tipo_contas.relatoriobalancete','=',1)
            ->where('lancamentos.receita','=',0)
            ->where('lancamentos.data','<=',$data_convertida)
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->get();

            $balanceteR = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->select('contas.nome', 'tipo_contas.descricao',
            DB::raw('SUM(lancamentos.debito) as total_debito'), 
            DB::raw('SUM(lancamentos.credito) as total_credito'))
            ->where('tipo_contas.relatoriobalancete','=',1)
            ->where('lancamentos.receita','=',1)
            ->where('lancamentos.data','<=',$data_convertida)
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->get();
        }
        else{
            request()->session()->flash('alert-info','Informe a Data.');
            return redirect("/relatorios");            
        }

        $balancete = [];

        foreach($balanceteO as $valor){
            array_push($balancete, $valor->nome);
            array_push($balancete, $valor->descricao);
            array_push($balancete, $valor->total_debito);
            array_push($balancete, $valor->total_credito);
        }
        $pdf = PDF::loadView('pdfs.balancete', [
                             'balanceteO' => $balanceteO,
                             'balanceteR' => $balanceteR,
                             'periodo'    => $periodo,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("balancete.pdf");
    }

    public function acompanhamento(Request $request){
        if($request->grupo != null){
            $tiposconta     = TipoConta::All();
            $acompanhamento = Conta::All();
        } else {
            request()->session()->flash('alert-info','Informe o Grupo.');
            return redirect("/relatorios");            
        }
        if(($request->data_inicial != null) and ($request->data_final != null)){
            $inicial = FormataDataService::handle($request->data_inicial);
            $final = FormataDataService::handle($request->data_final);
            $inicio = Carbon::parse($inicial);
            $fim = Carbon::parse($final);  
            $periodo = $fim->diffInDays($inicio);
            if($periodo > 365){
                request()->session()->flash('alert-info','O período deve ser de no máximo 1 ano entre data inicial e final');
                return redirect("/relatorios");
            }  else {
            $acompanhamento = $acompanhamento->whereBetween('updated_at', [$inicial, $final]);
            }
        }
        $pdf = PDF::loadView('pdfs.acompanhamento', [
                             'acompanhamento' => $acompanhamento,
        ])->setPaper('a4', 'portrait');
        return $pdf->download("acompanhamento.pdf");
    }

    public function saldo_contas(Request $request){
        $movimento = Movimento::where('ano', session('ano'))->first();

        if($request->tipoconta_id != null){
            $descricao_tipoconta = TipoConta::descricao_tipo_conta($request->tipoconta_id);
            $saldo_contas = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->select('contas.nome', 'tipo_contas.descricao', DB::raw('SUM(lancamentos.debito) as total_debito'), DB::raw('SUM(lancamentos.credito) as total_credito'))
            ->where('contas.tipoconta_id','=',$request->tipoconta_id)
            ->where('lancamentos.movimento_id', $movimento->id)
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->get();
        }
        else{
            request()->session()->flash('alert-info','Informe o Tipo de Conta.');
            return redirect("/relatorios");            
        }
        $pdf = PDF::loadView('pdfs.saldo_contas', [
                             'saldo_contas'        => $saldo_contas,
                             'descricao_tipoconta' => $descricao_tipoconta,
                             'movimento_anos'  => Movimento::movimento_anos()
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_contas.pdf");
    }

    public function saldo_dotacoes(Request $request){
        $movimento = Movimento::where('ano', session('ano'))->first();

        if($request->grupo != null){
            $saldo_dotacoes = DB::table('fic_orcamentarias')
            ->join('dot_orcamentarias', 'fic_orcamentarias.dotacao_id', '=', 'dot_orcamentarias.id')
            ->select('dot_orcamentarias.dotacao', 'dot_orcamentarias.grupo', 'dot_orcamentarias.item', 
                DB::raw('SUM(fic_orcamentarias.debito) as total_debito'),
                DB::raw('SUM(fic_orcamentarias.credito) as total_credito'))
            ->where('dot_orcamentarias.grupo','=',$request->grupo)
            ->where('movimento_id', $movimento->id)
            ->groupBy('dot_orcamentarias.dotacao', 'dot_orcamentarias.grupo', 'dot_orcamentarias.item')
            ->get();
        }
        else{
            request()->session()->flash('alert-info','Informe o Grupo.');
            return redirect("/relatorios");            
        }
        $pdf = PDF::loadView('pdfs.saldo_dotacoes', [
                             'saldo_dotacoes' => $saldo_dotacoes,
                             'grupo'          => $request->grupo,
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_dotacoes.pdf");
    }

    public function lancamentos(Request $request){
        if($request->conta == null){
            request()->session()->flash('alert-info','Informe pelo menos a Conta.');
            return redirect("/relatorios");
        }
        if(($request->data_inicial != null) and ($request->data_final != null)){
            $inicial = FormataDataService::handle($request->data_inicial);
            $final = FormataDataService::handle($request->data_final);
            $inicio = Carbon::parse($inicial);
            $fim = Carbon::parse($final);  
            $periodo = $fim->diffInDays($inicio);
            if($periodo > 30){
                request()->session()->flash('alert-info','O período deve ser de no máximo 30 dias entre data inicial e final');
                return redirect("/relatorios");
            } else {
                $lancamentos = Lancamento::whereHas('contas', function ($query) use ($request) {
                    $query->where('conta_id', $request->conta);
                })
                ->whereBetween('data', [$inicial, $final])
                ->get();
            }
        }
        if($request->grupo){
            $lancamentos = $lancamentos->where('grupo', $request->grupo);
        }
        $nome_conta  = Conta::nome_conta($request->conta);
        $pdf = PDF::loadView('pdfs.lancamentos', [
                             'lancamentos' => $lancamentos,
                             'nome_conta'  => $nome_conta[0]->nome,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("lancamentos.pdf");
    }

    public function ficha_orcamentaria(Request $request){
        $ficha_orcamentaria = new FicOrcamentaria;
        if($request->dotacao_id != null){
            $ficha_orcamentaria = $ficha_orcamentaria->where('dotacao_id','=',$request->dotacao_id);
        } else {
            request()->session()->flash('alert-info','Informe pelo menos a Dotação.');
            return redirect("/relatorios");
        }
        if(($request->data_inicial != null) and ($request->data_final != null)){
            $data_inicial_convertida = implode("-", array_reverse(explode("/", $request->data_inicial)));
            $data_final_convertida   = implode("-", array_reverse(explode("/", $request->data_final)));
            $ficha_orcamentaria      = $ficha_orcamentaria->whereBetween('data', [$data_inicial_convertida, $data_final_convertida]);
        }
        if($request->descricao != null){
            $ficha_orcamentaria = $ficha_orcamentaria->where('descricao','=',$request->descricao);
        }
        if($request->observacao != null){
            $ficha_orcamentaria = $ficha_orcamentaria->where('observacao','=',$request->observacao);
        }
        $ficha_orcamentaria = $ficha_orcamentaria->orderBy('data')->get();
        $dotacao = DotOrcamentaria::dotacao($request->dotacao_id);
        $pdf = PDF::loadView('pdfs.ficha_orcamentaria', [
                             'ficha_orcamentaria' => $ficha_orcamentaria,
                             'dotacao'            => $dotacao[0]->dotacao,

        ])->setPaper('a4', 'landscape');
        return $pdf->download("ficha_orcamentaria.pdf");
    }

    public function despesas_miudas(Request $request){
        if(($request->data_inicial != null) and ($request->data_final != null)) {
            $data_inicial_convertida = implode("-", array_reverse(explode("/", $request->data_inicial)));
            $data_final_convertida   = implode("-", array_reverse(explode("/", $request->data_final)));
            $despesas_miudas      = FicOrcamentaria::whereBetween('data', [$data_inicial_convertida, $data_final_convertida])->get();
        } else {
            request()->session()->flash('alert-info','Informe o período.');
            return redirect("/relatorios");
        }
        $pdf = PDF::loadView('pdfs.despesas_miudas', [
                             'despesas_miudas' => $despesas_miudas,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("despesas_miudas.pdf");
    }
}
