<?php

namespace App\Http\Controllers;

use App\Models\Lancamento;
use App\Models\Movimento;
use App\Models\Conta;
use App\Models\Nota;
use App\Models\TipoConta;
use Illuminate\Http\Request;
use App\Http\Requests\LancamentoRequest;
use App\Http\Requests\PercentualRequest;
use Carbon\Carbon;
use DB;
use Redirect;
use App\Services\LancamentoService;
use App\Services\MovimentoService;

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $this->authorize('Administrador');

        return view('lancamentos.index', [
            'lancamentos'         => collect(),
            'total_debito'        => 0,
            'total_credito'       => 0,
            'hoje'                => Carbon::now()->format('d/m/Y'),
            'lista_contas_ativas' => Conta::lista_contas_ativas(),
            'movimento_anos'  => Movimento::movimento_anos()
        ]);
    }

    public function search(Request $request){
        $this->authorize('Administrador');

        $movimento = MovimentoService::anomovimento();
        $lancamentos = LancamentoService::saldo($movimento->id, $request->conta_id, $request->grupo);

        return view('lancamentos.index', [
                    'lancamentos'         => $lancamentos,
                    'total_debito'        => $lancamentos->sum('valor_debito'),
                    'total_credito'       => $lancamentos->sum('valor_credito'),
                    'hoje'                => Carbon::now()->format('d/m/Y'),
                    'lista_contas_ativas' => Conta::lista_contas_ativas(),
                    'movimento_anos'  => Movimento::movimento_anos()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $this->authorize('Administrador');

        $tiposdecontas = TipoConta::lista_tipos_contas();

        return view('lancamentos.create', [
                    'lancamento'          => new Lancamento,
                    'movimento_ativo'     => Movimento::movimento_ativo(),
                    'contas'              => Conta::lista_contas_ativas(),
                    'lista_descricoes'    => Nota::lista_descricoes(),
                    'lista_observacoes'   => Nota::lista_observacoes(),
                    'nome_conta_numero2'  => Conta::nome_conta_numero(2),
                    'nome_conta_numero3'  => Conta::nome_conta_numero(3),
                    'nome_conta_numero4'  => Conta::nome_conta_numero(4),
                    'tiposdecontas'        => $tiposdecontas
        ]);
    }

    public function getLancamentoContas(Request $request)
    {
        if($request->has('search')) {
            $contas = Conta::where('tipoconta_id', $request->search)
                      ->orderby('nome','asc')->get();
        }
        $response = array();
        foreach($contas as $conta){
            $response[] = array(
                "id" => $conta->id,
                "nome" => $conta->nome,
            );
        }
        return response()->json($response);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LancamentoRequest $request){

        $this->authorize('Administrador');

        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $lancamento = Lancamento::create($validated);
        $request->session()->flash('alert-success', 'Lançamento cadastrado com sucesso!');
        return redirect("/lancamentos/{$lancamento->id}");
    }

    public function storePercentual(Lancamento $lancamento, PercentualRequest $request){

        $this->authorize('Administrador');

        $lancamento['id'] = $lancamento->id;
        $contas_percentual[$request['contas']] = ['percentual' => str_replace(',', '.', $request['percentual'])];
        try {
            $lancamento->contas()->attach($contas_percentual);
        }
        catch(\Illuminate\Database\QueryException $error) {
            return redirect()->back()->withErrors(($error->getCode() === '23000') ? 'Conta duplicada' : '');
        }
        $request->session()->flash('alert-success', 'Percentual cadastrado com sucesso!');

        return redirect("/lancamentos/{$lancamento->id}");
    }

    private function mapContas($request)
    {
        $contas_percentual = [];
            foreach($request['contas'] as $key=>$valor){
            $contas_percentual[$valor] = ['percentual' => $request['percentual']];
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

        $this->authorize('Administrador');

        $tiposdecontas = TipoConta::lista_tipos_contas();
        $contas = Conta::lista_contas_ativas();
        $lancamento->load('contas');

        return view('lancamentos.show', [
            'lancamento' => $lancamento,
            'tiposdecontas' => $tiposdecontas,
            'contas' => $contas
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
        $validated['user_id'] = auth()->user()->id;
        $validated['receita'] = $request->has('receita');
        $lancamento->update($validated);
        $request->session()->flash('alert-success', 'Lançamento alterado com sucesso!');
        return redirect("/lancamentos/{$lancamento->id}");
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
        $request->session()->flash('alert-success', 'Lançamento deletado com sucesso!');
        return redirect()->route('lancamentos.index');
    }

    public function destroyPercentual(Lancamento $lancamento, Request $request){
        $this->authorize('Administrador');
        DB::table('conta_lancamento')->where('conta_id', $request->conta_id)
                                        ->where('lancamento_id', $request->lancamento_id)
                                        ->delete();
        $request->session()->flash('alert-success', 'Percentual deletado com sucesso!');
        return back();
    }
}
