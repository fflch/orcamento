<?php

namespace App\Http\Controllers;

use App\Models\FicOrcamentaria;
use App\Models\DotOrcamentaria;
use App\Models\Nota;
use App\Models\Movimento;
use App\Models\TipoConta;
use App\Models\Conta;

use Illuminate\Http\Request;
use App\Http\Requests\FicOrcamentariaRequest;


class FicOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
            $total_debito  += $ficorcamentaria->debito;
            $total_credito += $ficorcamentaria->credito;
        }

        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias();
        return view('ficorcamentarias.index', compact('ficorcamentarias','total_debito','total_credito','lista_dotorcamentarias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Todos');
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();
        $lista_tipos_contas = TipoConta::lista_tipos_contas();

        return view('ficorcamentarias.create', 
                    compact('lista_dotorcamentarias',
                            'lista_descricoes',
                            'lista_observacoes',
                            'lista_tipos_contas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cpfo(FicOrcamentariaRequest $request)
    {
        //dd('Cheguei aqui.');
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
        $lista_contas = Conta::lista_contas();

        return view('ficorcamentarias.contrapartida', 
                    compact('request_FO',
                            'tipocontaid_quantidades',
                            'tipocontaid_descricaoconta',
                            'lista_contas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Todos');
        //$request->data = implode("-", array_reverse(explode("/", $request->data)));
        //dd('Cheguei aqui MESMO.');
        dd($request);

        $movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['movimento_id'] = $movimento_ativo->id;
        $validated['dotacao_id']   = $request->dotacao_id;

        FicOrcamentaria::create($validated);

        $request->session()->flash('alert-success', 'Ficha Orçamentária cadastrada com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function show(FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('Todos');
        return view('ficorcamentarias.show', compact('ficorcamentaria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function edit(FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('Administrador');
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();

        return view('ficorcamentarias.edit', compact('ficorcamentaria','lista_dotorcamentarias','lista_descricoes','lista_observacoes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function update(FicOrcamentariaRequest $request, FicOrcamentaria $ficorcamentaria)
    {
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
    public function destroy(FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('Administrador');
        $ficorcamentaria->delete();
        return redirect()->route('ficorcamentarias.index')->with('alert-success', 'Ficha Orçamentária deletada com sucesso!');
    }
}
