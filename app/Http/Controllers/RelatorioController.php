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
use App\Services\MovimentoService;
use App\Services\FicOrcamentariaService;
use App\Services\Query;

class RelatorioController extends Controller
{
    public function relatorios(){
        $this->authorize('Todos');

        return view('relatorios.index', [
                    'tiposdecontas' => TipoConta::lista_tipos_contas(),
                    'contas' => Conta::lista_contas_ativas(),
                    'movimento_anos'  => Movimento::movimento_anos(),
                    'movimento_ativo'        => Movimento::movimento_ativo(),
                    'lista_tipos_contas'     => TipoConta::lista_tipos_contas(),
                    'lista_dotorcamentarias' => DotOrcamentaria::lista_dotorcamentarias_ativas(),
                    'lista_descricoes'       => Nota::lista_descricoes(),
                    'lista_observacoes'      => Nota::lista_observacoes()
        ]);
    }

    public function balancete(Request $request){

        $ano = explode("/", $request->data);
        $movimento = Movimento::where('ano', session('ano'))->first();

        if($request->data != null && $ano[2] == $movimento->ano){

            $periodo = FormataDataService::handle($request->data);

            $saldos = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->selectRaw('contas.nome, tipo_contas.descricao,
                        SUM(ROUND(((lancamentos.debito * conta_lancamento.percentual) / 100),2)) as sum_debito,
                        SUM(ROUND(((lancamentos.credito * conta_lancamento.percentual) / 100),2)) as sum_credito')
            ->where('tipo_contas.relatoriobalancete','=',1)
            ->where('lancamentos.movimento_id', '=', $movimento->id)
            ->where('lancamentos.data','<=',$periodo)
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->orderBy('contas.nome')
            ->get();

            // Monta um array de array das contas e duas chaves saldo_orcamento e saldo_renda
            $contas = $saldos->pluck('nome')->toArray();
            $balancete = [];
            foreach($contas as $conta){
                $balancete[$conta] = [
                    'saldo_orcamento' => 0.0,
                    'saldo_renda' => 0.0
                ];
            }
            // Preenche o array balancete
            foreach($saldos as $saldo){
                if($saldo->descricao == "ORÇAMENTO"){
                    $balancete[$saldo->nome]['saldo_orcamento'] = $saldo->sum_credito - $saldo->sum_debito;
                } else {
                    $balancete[$saldo->nome]['saldo_renda'] = $saldo->sum_credito - $saldo->sum_debito;
                }
            }

        } else {
            request()->session()->flash('alert-info','Ao informar a data, certifique-se de que o ano é correpondente com o da sessão.');
            return redirect("/relatorios");
        }

        $pdf = PDF::loadView('pdfs.balancete', [
                             'balancete' => $balancete,
                             'periodo'    => $periodo,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("balancete.pdf");
    }

    public function acompanhamento(Request $request){
        $ano = explode("/", $request->data);
        $movimento = MovimentoService::anomovimento();
        $periodo = FormataDataService::handle($request->data);
        $receita = $request->receita_acompanhamento ?? 0;

        if($request->grupo != null && $ano[2] == $movimento->ano){

            //Monta a parte de cima do PDF (créditos)
            $saldo_inicial = Query::RELAFICHAORCAMENTSDOINICIAL($movimento->id, $request->grupo, $receita);

            $suplementacoes = Query::RELAGASTOSUPLEMENTACAO($movimento->id, $request->grupo, $receita);

            $gastos = Query::RELAGASTONAOSUPLEMENTACAO($movimento->id, $request->grupo, $receita, $periodo);

            //código usado somente quando o acompanhamento é referente ao grupo 080 (conta)
            $naoverbaprevisoes = [];
            $renda_industriais = [];
            if((int)$request->grupo == 80){
                $naoverbaprevisoes = Query::RELAPREVISAONAOVERBA($movimento->id, $request->grupo, $receita);
                $renda_industriais = Query::RELARENDAINDUSTRIALADM($movimento->id, $request->grupo, $receita);
            }

        } else {
            request()->session()->flash('alert-info','Informe o Grupo e certifique-se de que o ano é correpondente com o da sessão.');
            return redirect("/relatorios");
        }

        if(empty($saldo_inicial)){
            $saldo_inicial = new \StdClass;
            $saldo_inicial->descricaogrupo = 'Saldo Inicial';
            $saldo_inicial->saldoinicial = 0;
        }
        else $saldo_inicial = $saldo_inicial[0];

        $pdf = PDF::loadView('pdfs.acompanhamento', [
                             'saldo_inicial' => $saldo_inicial,
                             'suplementacoes' => $suplementacoes,
                             'total_suplementacoes' => collect($suplementacoes)->sum('total'),
                             'renda_industriais' => $renda_industriais,
                             'total_renda_industrial' => collect($renda_industriais)->sum('total'),
                             'gastos' => $gastos,
                             'total_gastos' => collect($gastos)->sum('total'),
                             'naoverbaprevisoes' => $naoverbaprevisoes,
                             'total_naoverbaprevisoes' => collect($naoverbaprevisoes)->sum('total'),
                             'grupo' => $request->grupo
        ])->setPaper('a4', 'portrait');
        return $pdf->download("acompanhamento.pdf");
    }


    public function saldo_projetos_especiais(Request $request){

        $movimento = Movimento::where('ano', session('ano'))->first();

        // Selecionando tipo de conta PROJETOS ESPECIAIS
        $projetos_especiais = TipoConta::where('descricao','PROJETOS ESPECIAIS')->first();

        $descricao_tipoconta = TipoConta::descricao_tipo_conta($request->tipoconta_id);

        $saldo_contas_renda_industrial = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->select('contas.nome', 'tipo_contas.descricao', DB::raw('(SUM(lancamentos.credito)) - (SUM(lancamentos.debito)) as total'))
            ->where('contas.tipoconta_id','=',$projetos_especiais->id)
            ->where('lancamentos.movimento_id', $movimento->id)
            ->where('contas.nome','LIKE','%RENDA INDUSTRIAL%')
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->get();


        $saldo_contas_orcamento = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->select('contas.nome', 'tipo_contas.descricao', DB::raw('(SUM(lancamentos.credito)) - (SUM(lancamentos.debito)) as total'))
            ->where('contas.tipoconta_id','=',$projetos_especiais->id)
            ->where('lancamentos.movimento_id', $movimento->id)
            ->where('contas.nome','LIKE','%ORÇAMENTO%')
            ->groupBy('contas.nome', 'tipo_contas.descricao')
            ->get();

        $pdf = PDF::loadView('pdfs.saldo_projetos_especiais', [
                             'saldo_contas_orcamento'        => $saldo_contas_orcamento,
                             'saldo_contas_renda_industrial' => $saldo_contas_renda_industrial,
                             'total_saldo_contas_renda_industrial' => $saldo_contas_renda_industrial->sum('total'),
                             'total_saldo_contas_orcamento' => $saldo_contas_orcamento->sum('total'),
                             'descricao_tipoconta' => $descricao_tipoconta,
                             'movimento_anos'  => Movimento::movimento_anos()
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_projetos_especiais.pdf");
    }

    public function saldo_contas(Request $request){

        $movimento = Movimento::where('ano', session('ano'))->first();

        if($request->tipoconta_id != null){
            $descricao_tipoconta = TipoConta::descricao_tipo_conta($request->tipoconta_id);
            $saldo_contas = DB::table('contas')
            ->join('tipo_contas', 'contas.tipoconta_id', '=', 'tipo_contas.id')
            ->join('conta_lancamento', 'contas.id', '=', 'conta_lancamento.conta_id')
            ->join('lancamentos', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
            ->select('contas.nome', 'tipo_contas.descricao', DB::raw('(SUM(lancamentos.credito)) - (SUM(lancamentos.debito)) as total'))
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
                             'total_saldo_contas' => $saldo_contas->sum('total'),
                             'descricao_tipoconta' => $descricao_tipoconta,
                             'movimento_anos'  => Movimento::movimento_anos()
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_contas.pdf");
    }

    public function saldo_dotacoes(Request $request){
        $movimento = MovimentoService::anomovimento();

        if($request->grupo == null){
            request()->session()->flash('alert-info','Informe o Grupo.');
            return redirect("/relatorios");
        }
        if($request->receita_dotacao == null){
            $saldo_dotacoes = DB::table('fic_orcamentarias')
            ->join('dot_orcamentarias', 'fic_orcamentarias.dotacao_id', '=', 'dot_orcamentarias.id')
            ->select('dot_orcamentarias.dotacao', 'dot_orcamentarias.grupo', 'dot_orcamentarias.item',
                DB::raw('SUM(fic_orcamentarias.debito) as total_debito'),
                DB::raw('SUM(fic_orcamentarias.credito) as total_credito'))
            ->where('dot_orcamentarias.grupo','=',$request->grupo)
            ->where('dot_orcamentarias.receita','=',0)
            ->where('movimento_id', $movimento->id)
            ->groupBy('dot_orcamentarias.dotacao', 'dot_orcamentarias.grupo', 'dot_orcamentarias.item')
            ->get();
        }
        else{
            $saldo_dotacoes = DB::table('fic_orcamentarias')
            ->join('dot_orcamentarias', 'fic_orcamentarias.dotacao_id', '=', 'dot_orcamentarias.id')
            ->select('dot_orcamentarias.dotacao', 'dot_orcamentarias.grupo', 'dot_orcamentarias.item',
                DB::raw('SUM(fic_orcamentarias.debito) as total_debito'),
                DB::raw('SUM(fic_orcamentarias.credito) as total_credito'))
            ->where('dot_orcamentarias.grupo','=',$request->grupo)
            ->where('dot_orcamentarias.receita','=',1)
            ->where('movimento_id', $movimento->id)
            ->groupBy('dot_orcamentarias.dotacao', 'dot_orcamentarias.grupo', 'dot_orcamentarias.item')
            ->get();
        }
        $pdf = PDF::loadView('pdfs.saldo_dotacoes', [
                             'saldo_dotacoes' => $saldo_dotacoes,
                             'grupo'          => $request->grupo,
        ])->setPaper('a4', 'portrait');
        return $pdf->download("saldo_dotacoes.pdf");
    }

    //verificar se o ano da data é igual ao escolhido na sessão
    public function lancamentos(Request $request){
        if($request->contas == null){
            request()->session()->flash('alert-info','Informe pelo menos a Conta.');
            return redirect("/relatorios");
        }
        if(($request->data_inicial != null) and ($request->data_final != null)){
            $movimento = Movimento::where('ano', session('ano'))->first();
            $lancamentos = LancamentoService::saldo($movimento->id, $request->contas, $request->grupo,
                FormataDataService::handle($request->data_inicial),
                FormataDataService::handle($request->data_final));

        } else {
            request()->session()->flash('alert-info','Informe as duas datas requeridas.');
            return back();
        }

        $pdf = PDF::loadView('pdfs.lancamentos', [
                             'conta_id'      => $request->contas,
                             'lancamentos'   => $lancamentos,
                             'nome_conta'    => Conta::nome_conta($request->contas),
                             'total_debito'  => $lancamentos->sum('valor_debito'),
                             'total_credito' => $lancamentos->sum('valor_credito')
        ])->setPaper('a4', 'landscape');
        return $pdf->download("lancamentos.pdf");
    }

    //verificar se o ano da data é igual ao escolhido na sessão
    public function ficha_orcamentaria(Request $request){
        $movimento = MovimentoService::anomovimento();
        if($request->dotacao_id == null){
            request()->session()->flash('alert-info','Informe pelo menos a Dotação.');
            return redirect("/relatorios");
        }
        if(($request->data_inicial != null) and ($request->data_final != null)){
            $inicial = FormataDataService::handle($request->data_inicial);
            $final = FormataDataService::handle($request->data_final);
            $ficha_orcamentaria = FicOrcamentaria::when($request->dotacao_id, function ($query) use ($request) {
                return $query->where('dotacao_id', $request->dotacao_id);
            })
            ->whereBetween('data', [$inicial, $final])
            ->where('movimento_id', $movimento->id)
            ->orderBy('data')
            ->get();

            $totais = FicOrcamentariaService::handle($ficha_orcamentaria);

        } else {
            request()->session()->flash('alert-info','Informe as duas datas requeridas.');
            return back();
        }
        $dotacao = DotOrcamentaria::dotacao($request->dotacao_id);
        $pdf = PDF::loadView('pdfs.ficha_orcamentaria', [
                             'ficha_orcamentaria' => $ficha_orcamentaria,
                             'dotacao'            => $dotacao[0]->dotacao,
                             'total_debito'        => $totais['total_debito'],
                             'total_credito'       => $totais['total_credito']

        ])->setPaper('a4', 'landscape');
        return $pdf->download("ficha_orcamentaria.pdf");
    }
}
