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

class LancamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');

        $movimento = Movimento::where('ano', session('ano'))->first();

        $lancamentos = Lancamento::when($request->conta_id, function ($query) use ($request) {
                            $query->whereHas('contas', function ($query) use ($request) {
                                $query->where('conta_id', $request->conta_id);
                            });
                       })
                       ->when($request->busca_grupo, function ($query) use ($request) {
                            return $query->where('grupo', '=', $request->busca_grupo);
                        })
                       ->where('movimento_id', $movimento->id)
                       ->orderBy('data', 'ASC')->paginate(10);
        
        $hoje = Carbon::now()->format('d/m/Y');

        $total_debito  = 0.00;
        $total_credito = 0.00;
        $concatena_debito = '';
               
        foreach($lancamentos as $key=>$lancamento){           
            $lancamento->conta = Conta::find(request()->conta_id);
            $lancamento->debito_valor = $lancamento->debito_raw;
            $lancamento->credito_valor = $lancamento->credito_raw;

            if($request->conta_id || $request->busca_grupo){
                $relation = DB::table('conta_lancamento')
                                ->where('lancamento_id',$lancamento->id)
                                ->where('conta_id',$request->conta_id)
                                ->first();
                
                if($relation != null){
                    $lancamento->debito_valor = number_format(((float)$lancamento->debito_raw * $relation->percentual/100),2, ',', '.');
                    $lancamento->credito_valor = number_format(((float)$lancamento->credito_raw * $relation->percentual/100),2, ',', '.');
                  
                    $saldos = DB::table('lancamentos')
                    ->join('conta_lancamento', 'lancamentos.id', '=', 'conta_lancamento.lancamento_id')
                    ->selectRaw('SUM(lancamentos.debito) as total_debito,
                                SUM(lancamentos.credito) as total_credito')
                    ->where('conta_id', $request->conta_id)
                    ->where('movimento_id', $movimento->id)
                    ->get();      

                    foreach($saldos as $saldo){
                        $total_debito     += $saldo->total_debito * $relation->percentual/100;
                        $concatena_debito .= $saldo->total_debito . ' -  ';
                        $total_credito    += $saldo->total_credito * $relation->percentual/100;
                    }
                }
            }
            else {
                    $saldos = DB::table('lancamentos')
                    ->selectRaw('SUM(lancamentos.debito) as total_debito,
                                SUM(lancamentos.credito) as total_credito')
                    ->where('movimento_id', $movimento->id)
                    ->get();

                    foreach($saldos as $saldo){
                        $total_debito     += $saldo->total_debito;
                        $concatena_debito .= $saldo->total_debito . ' -  ';
                        $total_credito    += $saldo->total_credito;
                    }
                    
            }
        }

        return view('lancamentos.index', [
                    'lancamentos'         => $lancamentos,
                    'total_debito'        => $total_debito,
                    'total_credito'       => $total_credito,
                    'hoje'                => $hoje,
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

        $this->authorize('Todos');

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

        $this->authorize('Todos');

        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $lancamento_last = Lancamento::all()->last();
        $lancamento = Lancamento::create($validated);
        $calculaSaldoLancamento  = Lancamento::calculaSaldo($lancamento, $lancamento_last);
        $request->session()->flash('alert-success', 'Lançamento cadastrado com sucesso!');
        return redirect("/lancamentos/{$lancamento->id}");
    }

    public function storePercentual(Lancamento $lancamento, PercentualRequest $request){

        $this->authorize('Todos');

        $lancamento['id'] = $lancamento->id;
        $lancamento_last = Lancamento::all()->last();
        $contas_percentual[$request['contas']] = ['percentual' => str_replace(',', '.', $request['percentual'])];
        try {
            $lancamento->contas()->attach($contas_percentual);
        } 
        catch(\Illuminate\Database\QueryException $error) {
            return redirect()->back()->withErrors(($error->getCode() === '23000') ? 'Conta duplicada' : '');
        }
        $calculaSaldoLancamento   = Lancamento::calculaSaldo($lancamento, $lancamento_last);
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

        $this->authorize('Todos');

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
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $validated['user_id']     = auth()->user()->id;
        $lancamento_last = Lancamento::all()->last();
        $lancamento->update($validated);
        $calculaSaldoLancamento   = Lancamento::calculaSaldo($lancamento, $lancamento_last);
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
        $lancamento_last = Lancamento::all()->last();
        $lancamento->delete();
        $calculaSaldoLancamento = Lancamento::calculaSaldo($lancamento, $lancamento_last);
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
