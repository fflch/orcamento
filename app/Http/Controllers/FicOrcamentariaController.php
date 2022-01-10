<?php

namespace App\Http\Controllers;

use App\Models\FicOrcamentaria;
use App\Models\DotOrcamentaria;
use App\Models\Nota;
use App\Models\Movimento;
use App\Models\TipoConta;
use App\Models\Conta;
use App\Models\Lancamento;
use Illuminate\Http\Request;
use App\Http\Requests\FicOrcamentariaRequest;
use App\Http\Requests\FicOrcamentariaCPRequest;

class FicOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');
        if($request->dotacao_id != null){
            $ficorcamentarias = FicOrcamentaria::where('dotacao_id','=',$request->dotacao_id)->orderBy('data')->paginate(10);
        }
        else{
            $ficorcamentarias = FicOrcamentaria::orderBy('data')->paginate(10);
        }

        $total_debito  = 0.00;
        $total_credito = 0.00;
        foreach($ficorcamentarias as $ficorcamentaria){
            $total_debito  += $ficorcamentaria->debito_raw;
            $total_credito += $ficorcamentaria->credito_raw;
        }

        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias_ativas();
        return view('ficorcamentarias.index', compact('ficorcamentarias','total_debito','total_credito','lista_dotorcamentarias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->authorize('Todos');
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias_ativas();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();
        $lista_tipos_contas = TipoConta::lista_tipos_contas();

        return view('ficorcamentarias.create',[ 
                    'ficorcamentaria'        => new FicOrcamentaria,
                    'lista_dotorcamentarias' => $lista_dotorcamentarias,
                    'lista_descricoes'       => $lista_descricoes,
                    'lista_observacoes'      => $lista_observacoes,
                    'lista_tipos_contas'     => $lista_tipos_contas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cpfo(FicOrcamentariaRequest $request){
        $this->authorize('Todos');
        $tipocontaid_quantidades = $request->tipocontaid_quantidades;
        $chaves  = array_keys($tipocontaid_quantidades);
        $valores = array_values($tipocontaid_quantidades);
        $novos_valores = [];
        foreach($chaves as $chave){
            $descricao_conta = TipoConta::descricao_tipo_conta($chave);
            $valor = $descricao_conta;
            array_push($novos_valores, $valor);
        }
        $tipocontaid_descricaoconta = array_combine($chaves,$novos_valores);
        $request_FO = $request;
        $lista_contas_ativas = Conta::lista_contas_ativas();

        /*return redirect()->route('ficorcamentarias.contrapartida', 
        compact('request_FO',
                'tipocontaid_quantidades',
                'tipocontaid_descricaoconta',
                'lista_contas'));*/

        return view('ficorcamentarias.contrapartida', 
                    compact('request_FO',
                            'tipocontaid_quantidades',
                            'tipocontaid_descricaoconta',
                            'lista_contas_ativas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //public function store(FicOrcamentariaCPRequest $request)
    public function store(Request $request){
        $this->authorize('Todos');
        //dd($request);
        /*$data = $request->validate([
            "grupo"    => "required|array",
            "grupo.*"  => "required|distinct",
        ]);*/

        $movimento_ativo = Movimento::movimento_ativo();
        $fichaorcamentaria['dotacao_id']   = $request->dotacao_id_fo;
        $fichaorcamentaria['data']         = $request->data_fo;
        $fichaorcamentaria['empenho']      = $request->empenho_fo;
        $fichaorcamentaria['descricao']    = $request->descricao_fo;
        if($request->debito_fo)
            $fichaorcamentaria['debito']   = $request->debito_fo;
        else
            $fichaorcamentaria['credito']  = $request->credito_fo;
        $fichaorcamentaria['observacao']   = $request->observacao_fo;
        $fichaorcamentaria['user_id']      = auth()->user()->id;
        $fichaorcamentaria['movimento_id'] = $movimento_ativo->id;
        FicOrcamentaria::create($fichaorcamentaria);

        $last_fichaorcamentaria_id = FicOrcamentaria::latest()->first()->id;
        if(isset($request->conta_id)){
            for($i=0; $i < count($request->conta_id); $i++){
                $lancamento['conta_id']           = $request->conta_id[$i];
                $lancamento['ficorcamentaria_id'] = $last_fichaorcamentaria_id;
                $lancamento['grupo']              = $request->grupo[$i];

                $lancamento['receita']            = $request->receita[$i];

                $lancamento['data']               = $request->data_fo;
                $lancamento['empenho']            = $request->empenho_fo;
                $lancamento['descricao']          = $request->descricao_fo;
                if($request->debito_fo)
                    $lancamento['debito']         = $request->debito[$i];
                else
                    $lancamento['credito']        = $request->credito[$i];
                $lancamento['observacao']         = $request->observacao_fo;
                $lancamento['user_id']            = auth()->user()->id;
                $lancamento['movimento_id']       = $movimento_ativo->id;        
                Lancamento::create($lancamento);
            }
        }

        if(!$request->conta_id)
            $request->session()->flash('alert-success', 'Ficha Orçamentária cadastrada com sucesso!');
        else
            $request->session()->flash('alert-success', 'Ficha Orçamentária e Contra-Partida(s) cadastrada(s) com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function show(FicOrcamentaria $ficorcamentaria){
        $this->authorize('Todos');
        return view('ficorcamentarias.show', compact('ficorcamentaria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function edit(FicOrcamentaria $ficorcamentaria){
        $this->authorize('Administrador');
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias_ativas();
        $lista_descricoes       = Nota::lista_descricoes();
        $lista_observacoes      = Nota::lista_observacoes();
        $lista_tipos_contas     = TipoConta::lista_tipos_contas();

        return view('ficorcamentarias.edit', compact('ficorcamentaria','lista_dotorcamentarias','lista_descricoes','lista_observacoes','lista_tipos_contas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function update(FicOrcamentariaRequest $request, FicOrcamentaria $ficorcamentaria){
        $this->authorize('Administrador');
        $movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $ficorcamentaria->user_id = auth()->user()->id;
        $ficorcamentaria->movimento_id = $movimento_ativo->id;
        $ficorcamentaria->dotacao_id = $request->dotacao_id;

        $ficorcamentaria->update($validated);

        $ficorcamentarias_dotacao = FicOrcamentaria::where('dotacao_id','=',$request->dotacao_id)->orderBy('data');
        $saldo  = 0.00;
        foreach($ficorcamentarias_dotacao as $calcula_saldo){
            $saldo += $calcula_saldo->credito - $calcula_saldo->debito;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
        }
        
        $request->session()->flash('alert-success', 'Ficha Orçamentária alterada com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(FicOrcamentaria $ficorcamentaria){
        $this->authorize('Administrador');
        $ficorcamentaria->delete();
        return redirect()->route('ficorcamentarias.index')->with('alert-success', 'Ficha Orçamentária deletada com sucesso!');
    }
}
