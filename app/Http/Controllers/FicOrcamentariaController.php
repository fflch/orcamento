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

        $ficorcamentarias = FicOrcamentaria::when($request->dotacao_id, function ($query) use ($request) {
                                $query->where('dotacao_id','=',$request->dotacao_id);
                            })
                            ->where('movimento_id',Movimento::movimento_ativo()->id)
                            ->orderBy('data', 'DESC')->paginate(10);

        $total_debito  = 0.00;
        $total_credito = 0.00;
        foreach($ficorcamentarias as $ficorcamentaria){
            $total_debito  += $ficorcamentaria->debito_raw;
            $total_credito += $ficorcamentaria->credito_raw;
        }
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias_ativas();
        return view('ficorcamentarias.index',[
                    'ficorcamentarias'       => $ficorcamentarias,
                    'total_debito'           => $total_debito,
                    'total_credito'          => $total_credito,
                    'lista_dotorcamentarias' => $lista_dotorcamentarias,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){

        $this->authorize('Todos');       
        
        return view('ficorcamentarias.create',[
                    'ficorcamentaria'        => new FicOrcamentaria,
                    'lista_dotorcamentarias' => DotOrcamentaria::lista_dotorcamentarias_ativas(),
                    'lista_descricoes'       => Nota::lista_descricoes(),
                    'lista_observacoes'      => Nota::lista_observacoes(),
                    'lista_tipos_contas'     => TipoConta::lista_tipos_contas(),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(FicOrcamentariaRequest $request){

        $this->authorize('Todos');
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $ficorcamentaria = FicOrcamentaria::create($validated);
        $request->session()->flash('alert-success', 'Ficha Orçamentária cadastrada com sucesso!');
        return redirect("/ficorcamentarias/{$ficorcamentaria->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function show(FicOrcamentaria $ficorcamentaria){
        $this->authorize('Todos');

        $lancamentos = Lancamento::where('ficorcamentaria_id',$ficorcamentaria->id)
                                    ->where('movimento_id',Movimento::movimento_ativo()->id)
                                    ->paginate(5);

        $tiposdecontas = TipoConta::lista_tipos_contas();
        $contas = Conta::lista_contas_ativas();

        return view('ficorcamentarias.show', [
            'ficorcamentaria' => $ficorcamentaria,
            'lancamentos'     => $lancamentos,
            'tiposdecontas' =>  $tiposdecontas,
            'contas' => $contas
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function edit(FicOrcamentaria $ficorcamentaria){
        $this->authorize('Administrador');
        return view('ficorcamentarias.edit',[
                    'ficorcamentaria'        => $ficorcamentaria,
                    'lista_dotorcamentarias' => DotOrcamentaria::lista_dotorcamentarias_ativas(),
                    'lista_descricoes'       => Nota::lista_descricoes(),
                    'lista_observacoes'      => Nota::lista_observacoes(),
                    'lista_tipos_contas'     => TipoConta::lista_tipos_contas(),
        ]);
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
        $validated = $request->validated();
        $validated['user_id']          = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;
        $ficorcamentaria->update($validated);
        $calculaSaldoFichaOrcamentaria  = FicOrcamentaria::calculaSaldo($ficorcamentaria->dotacao_id);
        $request->session()->flash('alert-success', 'Ficha Orçamentária alterada com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    public function storeCpfo(FicOrcamentaria $ficorcamentaria, FicOrcamentariaCPRequest $request){

        $this->authorize('Todos');

        $lancamento['ficorcamentaria_id'] = $ficorcamentaria->id;
        $lancamento['grupo']              = $request->grupo;
        $lancamento['receita']            = $request->receita;
        $lancamento['data']               = $ficorcamentaria->data;
        $lancamento['empenho']            = $ficorcamentaria->empenho;
        $lancamento['descricao']          = $ficorcamentaria->descricao;
        $lancamento['observacao']         = $ficorcamentaria->observacao;
        $lancamento['user_id']            = auth()->user()->id;
        $lancamento['movimento_id']       = Movimento::movimento_ativo()->id;
        if($request->debito){
            $lancamento['debito']         = $request->debito;
        }
        if($request->credito){
            $lancamento['credito']         = $request->credito;
        }
        $lancamento_obj = Lancamento::create($lancamento);
        $lancamento_obj->contas()->sync([$request->conta =>  ['percentual' => 100]]);
        $calculaSaldoLancamento   = Lancamento::calculaSaldo($lancamento);
        $request->session()->flash('alert-success', 'Contra-partida cadastrada com sucesso!');
        return redirect("/ficorcamentarias/{$ficorcamentaria->id}");
    }

    public function getContas(Request $request)
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(FicOrcamentaria $ficorcamentaria){
        $this->authorize('Administrador');
        $ficorcamentaria->delete();
        $calculaSaldoFichaOrcamentaria = FicOrcamentaria::calculaSaldo($ficorcamentaria->dotacao_id);
        return back()->with('alert-success', 'Ficha Orçamentária excluída com sucesso!');
    }
}
