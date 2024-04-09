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
                        SUM(lancamentos.debito) as total_debito,
                        SUM(lancamentos.credito) as total_credito')
            ->where('tipo_contas.relatoriobalancete','=',1)
            ->where('lancamentos.movimento_id', '=', $movimento->id)
            ->where('lancamentos.data','<=',$periodo)
            ->groupBy('contas.nome', 'tipo_contas.descricao')
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
                    $balancete[$saldo->nome]['saldo_orcamento'] = $saldo->total_credito - $saldo->total_debito;
                } else {
                    $balancete[$saldo->nome]['saldo_renda'] = $saldo->total_credito - $saldo->total_debito;
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
        $movimento = Movimento::where('ano', session('ano'))->first();

        if($request->grupo != null && $ano[2] == $movimento->ano){
            $periodo = FormataDataService::handle($request->data);

            $lancamentos = Lancamento::where('grupo',(int)$request->grupo)
                                    ->where('data', '<=', $periodo)
                                    ->where('movimento_id', '=', $movimento->id)
                                    ->join('conta_lancamento', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
                                    ->pluck('conta_id')
                                    ->toArray();

            $contas_id = array_unique($lancamentos);

            $table = [];
            foreach($contas_id as $conta_id){

                $conta = Conta::find($conta_id);

                $lancamentos_nesta_conta = Lancamento::where('grupo',(int)$request->grupo)
                                        ->where('data', '<=', $periodo)
                                        ->where('movimento_id', '=', $movimento->id)
                                        ->join('conta_lancamento', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
                                        ->where('conta_id', $conta_id)
                                        ->select('debito','credito', 'receita')->get();
                                
                if($request->receita_acompanhamento != null){
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

                $table[] = [
                    'nome_conta' => $conta->nome,
                    'saldo'      => array_sum($debitos) - array_sum($creditos),
                ];
            }  
        } else {
            request()->session()->flash('alert-info','Informe o Grupo e certifique-se de que o ano é correpondente com o da sessão.');
            return redirect("/relatorios");
        }
        
        $pdf = PDF::loadView('pdfs.acompanhamento', [
                             'table' => $table,
                             'periodo' => $periodo,
                             'grupo' => $request->grupo
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
            $inicial = FormataDataService::handle($request->data_inicial);
            $final = FormataDataService::handle($request->data_final);
            $lancamentos = Lancamento::whereHas('contas', function ($query) use ($request) {
                $query->where('conta_id', $request->contas);
            })
            ->when($request->grupo, function ($query) use ($request) {
                return $query->where('grupo', $request->grupo);
            })
            ->whereBetween('data', [$inicial, $final])
            ->orderBy('data')
            ->get();
        } else {
            request()->session()->flash('alert-info','Informe as duas datas requeridas.');
            return back();
        }
        $lancamentos->load('contas');
        $nome_conta  = Conta::nome_conta($request->contas);
        $pdf = PDF::loadView('pdfs.lancamentos', [
                             'conta_id'    => $request->contas,
                             'lancamentos' => $lancamentos,
                             'nome_conta'  => $nome_conta[0]->nome,
        ])->setPaper('a4', 'landscape');
        return $pdf->download("lancamentos.pdf");
    }

    //verificar se o ano da data é igual ao escolhido na sessão
    public function ficha_orcamentaria(Request $request){
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
            ->orderBy('data')
            ->get();
        } else {
            request()->session()->flash('alert-info','Informe as duas datas requeridas.');
            return back();
        }
        $dotacao = DotOrcamentaria::dotacao($request->dotacao_id);
        $pdf = PDF::loadView('pdfs.ficha_orcamentaria', [
                             'ficha_orcamentaria' => $ficha_orcamentaria,
                             'dotacao'            => $dotacao[0]->dotacao,

        ])->setPaper('a4', 'landscape');
        return $pdf->download("ficha_orcamentaria.pdf");
    }
}
