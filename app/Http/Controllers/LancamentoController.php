<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\Nota;
use Illuminate\Http\Request;
use App\Http\Requests\LancamentoRequest;
use App\Http\Controllers\DB;
//use Illuminate\Support\Facades\Redirect;

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
        if($request->conta_id != null){
            $lancamentos = Lancamento::where('conta_id','=',$request->conta_id)->orderBy('data')->paginate(10);
        }
        else{
            $lancamentos = Lancamento::orderBy('data')->paginate(10);
        }

        $total_debito  = 0.00;
        $total_credito = 0.00;
        foreach($lancamentos as $lancamento){
            $total_debito  += $lancamento->debito_raw;
            $total_credito += $lancamento->credito_raw;
        }

        $lista_contas_ativas      = Conta::lista_contas_ativas();
        return view('lancamentos.index', compact('lancamentos','total_debito','total_credito','lista_contas_ativas'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Todos');
        $lista_contas_ativas = Conta::lista_contas_ativas();
        $lista_descricoes    = Nota::lista_descricoes();
        $lista_observacoes   = Nota::lista_observacoes();
        $nome_conta_numero2  = Conta::nome_conta_numero(2);
        $nome_conta_numero3  = Conta::nome_conta_numero(3);
        $nome_conta_numero4  = Conta::nome_conta_numero(4);

        return view('lancamentos.create', [
            'lancamento'          => new Lancamento,
            'lista_contas_ativas' => $lista_contas_ativas,
            'lista_descricoes'    => $lista_descricoes,
            'lista_observacoes'   => $lista_observacoes,
            'nome_conta_numero2'  => $nome_conta_numero2,
            'nome_conta_numero3'  => $nome_conta_numero3,
            'nome_conta_numero4'  => $nome_conta_numero4,
        ]);
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
        $percentuais = [];
        array_push($percentuais, $request->percentual1);
        array_push($percentuais, $request->percentual2);
        array_push($percentuais, $request->percentual3);
        array_push($percentuais, $request->percentual4);
        $total_percentuais = array_sum($percentuais);

        /*if($total_percentuais != 100){
            request()->session()->flash('alert-info','O total dos percentuais deve ser 100.');
            //return redirect("/lancamentos/create");
            //Redirect::back()->withMessage('Profile saved!');
            return Redirect::back()->with('message','Operation Successful !');
        }*/

        //dd($request->data);
        //$data_convertida = implode("-", array_reverse(explode("/", $request->data)));
        $movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['movimento_id'] = $movimento_ativo->id;
        $validated['conta_id']     = $request->conta_id;

        Lancamento::create($validated);

        if($request->percentual1 != 100){
            for($i=2; $i<5; $i++){
                $contas = Conta::where('numero','=',$i)->get();
                $lancamento = new Lancamento;
                $lancamento->movimento_id = $movimento_ativo->id;
                $lancamento->conta_id     = $contas[0]->id;
                $lancamento->grupo        = $request->grupo;
                $lancamento->receita      = $request->receita;
                $lancamento->data         = $request->data;
                $lancamento->empenho      = $request->empenho;
                $lancamento->descricao    = $request->descricao;

                $lancamento->debito       = $request->debito * $percentuais[$i-1] / 100;
                $lancamento->credito      = $request->credito * $percentuais[$i-1] / 100;

                $lancamento->observacao   = $request->observacao;
                $lancamento->user_id      = auth()->user()->id;
                $lancamento->save();
            }
        }

        $lancamentos_conta = Lancamento::where('conta_id','=',$request->conta_id)->orderBy('data');
        $saldo  = 0.00;
        foreach($lancamentos_conta as $calcula_saldo){
            $saldo += $calcula_saldo->credito - $calcula_saldo->debito;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
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
        $lista_contas_ativas = Conta::lista_contas_ativas();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();
        $nome_conta_numero2  = Conta::nome_conta_numero(2);
        $nome_conta_numero3  = Conta::nome_conta_numero(3);
        $nome_conta_numero4  = Conta::nome_conta_numero(4);

        //return view('lancamentos.edit', compact('lancamento','lista_contas_ativas','lista_descricoes','lista_observacoes'));
        return view('lancamentos.edit', [
            //'lancamento'          => new Lancamento,
            'lancamento'          => $lancamento,
            'lista_contas_ativas' => $lista_contas_ativas,
            'lista_descricoes'    => $lista_descricoes,
            'lista_observacoes'   => $lista_observacoes,
            'nome_conta_numero2'  => $nome_conta_numero2,
            'nome_conta_numero3'  => $nome_conta_numero3,
            'nome_conta_numero4'  => $nome_conta_numero4,
        ]);
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

        $lancamentos_conta = Lancamento::where('conta_id','=',$request->conta_id)->orderBy('data');
        $saldo  = 0.00;
        foreach($lancamentos_conta as $calcula_saldo){
            $saldo += $calcula_saldo->credito - $calcula_saldo->debito;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
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

        $lancamentos_conta = Lancamento::where('conta_id','=',$lancamento->conta_id)->orderBy('data');
        $saldo  = 0.00;
        foreach($lancamentos_conta as $calcula_saldo){
            $saldo += $calcula_saldo->credito - $calcula_saldo->debito;
            $calcula_saldo->saldo = $saldo;
            $calcula_saldo->update();
        }

        return redirect()->route('lancamentos.index')->with('alert-success', 'Lançamento deletado com sucesso!');
    }
}
