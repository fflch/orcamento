<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\Nota;
use Illuminate\Http\Request;
use App\Http\Requests\LancamentoRequest;
use Redirect;

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');

        $lancamentos = Lancamento::when($request->conta_id, function ($query) use ($request) {
                            $query->whereHas('contas', function ($query) use ($request) {
                                $query->where('conta_id', $request->conta_id);
                            });
                       })
                       ->where('movimento_id',Movimento::movimento_ativo()->id)
                       ->orderBy('data', 'DESC')->paginate(10);

        $total_debito  = 0.00;
        $total_credito = 0.00;
        $concatena_debito = '';
        foreach($lancamentos as $lancamento){
            $total_debito     += $lancamento->debito_raw;
            $concatena_debito .= $lancamento->debito_raw . ' -  ';
            $total_credito    += $lancamento->credito_raw;
        }

        return view('lancamentos.index', [
                    'lancamentos'         => $lancamentos,
                    'total_debito'        => $total_debito,
                    'total_credito'       => $total_credito,
                    'lista_contas_ativas' => Conta::lista_contas_ativas(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $this->authorize('Todos');
        return view('lancamentos.create', [
                    'lancamento'          => new Lancamento,
                    'movimento_ativo'     => Movimento::movimento_ativo(),
                    'contas'              => Conta::lista_contas_ativas(),
                    'lista_descricoes'    => Nota::lista_descricoes(),
                    'lista_observacoes'   => Nota::lista_observacoes(),
                    'nome_conta_numero2'  => Conta::nome_conta_numero(2),
                    'nome_conta_numero3'  => Conta::nome_conta_numero(3),
                    'nome_conta_numero4'  => Conta::nome_conta_numero(4),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LancamentoRequest $request){

        $this->authorize('Todos');

        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $validated['empenho']      = $request->empenho;
        $lancamento = Lancamento::create($validated);
        $lancamento->contas()->sync($this->mapContas($validated));
        $calculaSaldoLancamento  = Lancamento::calculaSaldo($lancamento);
        $request->session()->flash('alert-success', 'Lançamento cadastrado com sucesso!');
        return redirect()->route('lancamentos.index');
    }

    private function mapContas($validated)
    {
        $contas_percentual = [];
        foreach($validated['contas'] as $key=>$valor){
            $contas_percentual[$valor] = ['percentual' => $validated['percentual'][$key]];

        }
        return $contas_percentual;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(Lancamento $lancamento){

        $this->authorize('Todos');

        return view('lancamentos.show', [
            'lancamento' => $lancamento->load('contas')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Lancamento $lancamento){
        
        $this->authorize('Administrador');

        return view('lancamentos.edit', [
            'lancamento'          => $lancamento,
            'movimento_ativo'     => Movimento::movimento_ativo(),
            'contas'              => Conta::lista_contas_ativas(),
            'lista_descricoes'    => Nota::lista_descricoes(),
            'lista_observacoes'   => Nota::lista_observacoes(),
            'nome_conta_numero2'  => Conta::nome_conta_numero(2),
            'nome_conta_numero3'  => Conta::nome_conta_numero(3),
            'nome_conta_numero4'  => Conta::nome_conta_numero(4),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function update(LancamentoRequest $request, Lancamento $lancamento){
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $validated['user_id']     = auth()->user()->id;
        $lancamento->update($validated);
        $lancamento->contas()->sync($this->mapContas($validated));
        $calculaSaldoLancamento   = Lancamento::calculaSaldo($lancamento);
        $request->session()->flash('alert-success', 'Lançamento alterado com sucesso!');
        return redirect()->route('lancamentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request, Lancamento $lancamento){
        $this->authorize('Administrador');
        $lancamento->delete();
        $calculaSaldoLancamento = Lancamento::calculaSaldo($lancamento);
        $request->session()->flash('alert-success', 'Lançamento alterado com sucesso!');
        return redirect()->route('lancamentos.index');    }
}
