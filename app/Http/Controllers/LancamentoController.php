<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\Nota;
use Illuminate\Http\Request;
use App\Http\Requests\LancamentoRequest;

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Todos');
        if($request->busca != null){
            $lancamentos = Lancamento::where('conta_id','=',$request->busca)->orderBy('data')->paginate(10);
        }
        else{
            $lancamentos = Lancamento::orderBy('data')->paginate(10);
        }

        $total_debito  = 0.00;
        $total_credito = 0.00;
        foreach($lancamentos as $lancamento){
            $total_debito  += str_replace(',', '.', $lancamento->debito);
            $total_credito += str_replace(',', '.', $lancamento->credito);
        }

        $lista_contas      = Conta::lista_contas();

        return view('lancamentos.index', compact('lancamentos','total_debito','total_credito','lista_contas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Todos');
        $lista_contas      = Conta::lista_contas();
        $lista_descricoes  = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();

        return view('lancamentos.create', compact('lista_contas','lista_descricoes','lista_observacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LancamentoRequest $request)
    {
        $this->authorize('Todos');
        //dd($request->conta_id);
        
        $request->data = implode("-", array_reverse(explode("/", $request->data)));
        //dd($request->data);
        $movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['movimento_id'] = $movimento_ativo->id;
        $validated['conta_id']     = $request->conta_id;

        Lancamento::create($validated);

        $lancamentos = Lancamento::where('conta_id','=',$request->conta_id)->orderBy('data');
        //dd($lancamentos);
        $saldo  = 0.00;
        foreach($lancamentos as $lancamento){
            $saldo = $saldo + ($lancamento->credito - $lancamento->debito);
            $lancamento->saldo = $saldo;
            $lancamento->update();
            //dd($saldo);
        }

        $request->session()->flash('alert-success', 'Lançamento cadastrado com sucesso!');
        return redirect()->route('lancamentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(Lancamento $lancamento)
    {
        $this->authorize('Todos');
        return view('lancamentos.show', compact('lancamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Lancamento $lancamento)
    {
        $this->authorize('Administrador');
        $lista_contas = Conta::lista_contas();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();

        return view('lancamentos.edit', compact('lancamento','lista_contas','lista_descricoes','lista_observacoes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function update(LancamentoRequest $request, Lancamento $lancamento)
    {
        $this->authorize('Administrador');
        $movimento_ativo          = Movimento::movimento_ativo();
        $validated = $request->validated();
        $lancamento->movimento_id = $movimento_ativo->id;
        $lancamento->conta_id     = $request->conta_id;
        $validated['user_id']     = auth()->user()->id;
        $lancamento->update($validated);

        $lancamentos_conta = Lancamento::where('conta_id','=',$request->conta_id)->get()->sortBy('data');
        //dd($lancamentos_conta);
        $saldo  = 0.00;
        foreach($lancamentos_conta as $calcula_saldo){
            $saldo += $calcula_saldo->credito - $calcula_saldo->debito;
            $calcula_saldo->saldo = $saldo;
            //$calcula_saldo->saldo = 0.00;

            $calcula_saldo->update();
            //dd($saldo);
        }
        
        $request->session()->flash('alert-success', 'Lançamento alterado com sucesso!');
        return redirect()->route('lancamentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lancamento $lancamento)
    {
        $this->authorize('Administrador');
        $lancamento->delete();

        $lancamentos = Lancamento::where('conta_id','=',$lancamento->conta_id)->get()->sortBy('data');
        //dd($lancamentos);
        $saldo  = 0.00;
        foreach($lancamentos as $lancamento){
            $saldo = $saldo + ($lancamento->credito - $lancamento->debito);
            $lancamento->saldo = $saldo;
            $lancamento->update();
            //dd($saldo);
        }

        return redirect()->route('lancamentos.index')->with('alert-success', 'Lançamento deletado com sucesso!');
    }
}
