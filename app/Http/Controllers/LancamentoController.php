<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\Nota;
use Illuminate\Http\Request;
use App\Http\Requests\LancamentoRequest;
use App\Http\Controllers\DB;
use Redirect;
//use Illuminate\Support\Facades\Redirect;

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');
        if($request->conta_id != null)
            $lancamentos = Lancamento::where('conta_id','=',$request->conta_id)->orderBy('data')->paginate(10);
        else
            $lancamentos = Lancamento::orderBy('data')->paginate(10);
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
                    'contas' => Conta::all(),
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
                    'lista_contas_ativas' => Conta::lista_contas_ativas(),
                    'lista_descricoes'    => Nota::lista_descricoes(),
                    'lista_observacoes'   => Nota::lista_observacoes(),
                    'nome_conta_numero2'  => Conta::nome_conta_numero(2),
                    'nome_conta_numero3'  => Conta::nome_conta_numero(3),
                    'nome_conta_numero4'  => Conta::nome_conta_numero(4),
                    'contas' => Conta::all(),
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

        $lancamento = Lancamento::create($validated);

        $lancamento->contas()->sync($this->mapContas($validated['contas']));



        // $percentuais = [];
        // array_push($percentuais, $request->percentual1);
        // array_push($percentuais, $request->percentual2);
        // array_push($percentuais, $request->percentual3);
        // array_push($percentuais, $request->percentual4);
        // $total_percentuais = array_sum($percentuais);
        // /*if($total_percentuais > 100){
        //     //dd('maior que 100');
        //     $request->session()->flash('alert-success', 'Maior que 100!');

        //     //return Redirect::back()->with('msg', 'The Message');
        // }*/
        // //$validated['total_percentuais']      = array_sum($percentuais);
        // //dd($total_percentuais);
        // $validated = $request->validated();
        // //dd($request->credito  * $request->percentual1 / 100);
        // if($request->debito == null){
        //     $validated['debito']  = 0.00;
        //     $validated['credito'] = $request->credito  * $request->percentual1 / 100;
        // }
        // if($request->credito == null){
        //     $validated['credito'] = 0.00;
        //     $validated['debito']  = $request->debito   * $request->percentual1 / 100;
        // }
        // //$validated['total_percentuais']      = array_sum($percentuais);
        
        // $validated['conta_id']     = $request->conta_id;
        // Lancamento::create($validated);
        // if($request->percentual1 != 100){
        //     for($i=2; $i<5; $i++){
        //         $contas = Conta::where('numero','=',$i)->get();
        //         $lancamento = new Lancamento;
        //         $lancamento->movimento_id = Movimento::movimento_ativo()->id;
        //         $lancamento->conta_id     = $contas[0]->id;
        //         $lancamento->grupo        = $request->grupo;
        //         $lancamento->receita      = $request->receita;
        //         $lancamento->data         = $request->data;
        //         $lancamento->empenho      = $request->empenho;
        //         $lancamento->descricao    = $request->descricao;
        //         /*
        //         if($request->debito != "0,00")
        //             $lancamento->debito   = $request->debito  * $percentuais[$i-1] / 100;
        //         if($request->credito != "0,00")
        //             $lancamento->credito  = $request->credito * $percentuais[$i-1] / 100;
        //         */
        //         $lancamento->observacao   = $request->observacao;
        //         $lancamento->user_id      = auth()->user()->id;
        //         $lancamento->save();
        //     }
        // }
        //$calculaSaldoLancamento  = Lancamento::calculaSaldo($request->conta_id);
        $request->session()->flash('alert-success', 'Lançamento cadastrado com sucesso!');
        return redirect()->route('lancamentos.index', [
            'contas' => Conta::all(),
        ]);
    }

    private function mapContas($contas)
    {
        return collect($contas)->map(function ($i) {
            return ['percentual' => $i];
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function show(Lancamento $lancamento){
        
        $this->authorize('Todos');

        return view('lancamentos.show', compact('lancamento'), [
            'contas' => Conta::all(),
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
        /*$lista_contas_ativas = Conta::lista_contas_ativas();
        $lista_descricoes    = Nota::lista_descricoes();
        $lista_observacoes   = Nota::lista_observacoes();
        $nome_conta_numero2  = Conta::nome_conta_numero(2);
        $nome_conta_numero3  = Conta::nome_conta_numero(3);
        $nome_conta_numero4  = Conta::nome_conta_numero(4);*/

        return view('lancamentos.edit', [
            'lancamento'          => $lancamento,
            'movimento_ativo'     => Movimento::movimento_ativo(),
            'lista_contas_ativas' => Conta::lista_contas_ativas(),
            'lista_descricoes'    => Nota::lista_descricoes(),
            'lista_observacoes'   => Nota::lista_observacoes(),
            'nome_conta_numero2'  => Conta::nome_conta_numero(2),
            'nome_conta_numero3'  => Conta::nome_conta_numero(3),
            'nome_conta_numero4'  => Conta::nome_conta_numero(4),
            'contas' => Conta::all(),
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
        $movimento_ativo          = Movimento::movimento_ativo();
        $validated = $request->validated();

        /*
        if($request->debito == null)
            $validated['debito']  = 0.00;

        if($request->credito == null)
            $validated['credito'] = 0.00;
        */

        $lancamento->movimento_id = $movimento_ativo->id;
        //$lancamento->conta_id     = $request->conta_id;
        $validated['user_id']     = auth()->user()->id;
        $lancamento->update($validated);
        $calculaSaldoLancamento   = Lancamento::calculaSaldo($request->conta_id);
        $request->session()->flash('alert-success', 'Lançamento alterado com sucesso!');
        return redirect()->route('lancamentos.index', [
            'contas' => Conta::all(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lancamento  $lancamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lancamento $lancamento){
        $this->authorize('Administrador');
        $lancamento->delete();
        $calculaSaldoLancamento = Lancamento::calculaSaldo($lancamento->conta_id);
        return redirect()->route('lancamentos.index',[
            'contas' => Conta::all(),
        ])
                         ->with('alert-success', 'Lançamento deletado com sucesso!');
    }
}
