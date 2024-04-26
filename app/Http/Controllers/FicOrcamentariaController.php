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
use Carbon\Carbon;
use App\Services\FicOrcamentariaService;

class FicOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Administrador');

        $movimento = Movimento::where('ano', session('ano'))->first();

        $ficorcamentarias = FicOrcamentaria::when($request->dotacao_id, function ($query) use ($request) {
                                $query->where('dotacao_id','=',$request->dotacao_id);
                            })
                            ->where('movimento_id', $movimento->id)
                            ->orderBy('data', 'ASC')->paginate(500);

        $totais = FicOrcamentariaService::handle($ficorcamentarias);  

        return view('ficorcamentarias.index',[
                    'ficorcamentarias'       => $ficorcamentarias,
                    'total_debito'        => $totais['total_debito'],
                    'total_credito'       => $totais['total_credito'],
                    'hoje'                   => Carbon::now()->format('d/m/Y'),
                    'lista_dotorcamentarias' => DotOrcamentaria::lista_dotorcamentarias_ativas(),
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

        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;    
        $ficorcamentaria_last = FicOrcamentaria::all()->last();  
        $ficorcamentaria = FicOrcamentaria::create($validated);
        $calculaSaldoFicha  = FicOrcamentaria::calculaSaldo($ficorcamentaria, $ficorcamentaria_last);
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
        $this->authorize('Administrador');

        $lancamentos = Lancamento::where('ficorcamentaria_id', $ficorcamentaria->id)->get();
        $lancamentos->load('contas');

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
        $validated['user_id'] = auth()->user()->id;
        $validated['movimento_id'] = Movimento::movimento_ativo()->id;   
        $ficorcamentaria_last = FicOrcamentaria::all()->last();  
        $ficorcamentaria->update($validated);
        $calculaSaldoFicha  = FicOrcamentaria::calculaSaldo($ficorcamentaria, $ficorcamentaria_last);
        $request->session()->flash('alert-success', 'Ficha Orçamentária alterada com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    public function storeCpfo(FicOrcamentaria $ficorcamentaria, FicOrcamentariaCPRequest $request){

        $this->authorize('Administrador');

        $lancamento_cpfo['ficorcamentaria_id'] = $ficorcamentaria->id;
        $lancamento_cpfo['grupo']              = $ficorcamentaria->dotacao->grupo;
        $lancamento_cpfo['receita']            = $request->receita;
        $lancamento_cpfo['data']               = $ficorcamentaria->data;
        $lancamento_cpfo['empenho']            = $ficorcamentaria->empenho;
        $lancamento_cpfo['descricao']          = $ficorcamentaria->descricao;
        $lancamento_cpfo['observacao']         = $ficorcamentaria->observacao;
        $lancamento_cpfo['user_id']            = auth()->user()->id;
        $lancamento_cpfo['movimento_id']       = Movimento::movimento_ativo()->id;
        if($request->debito){
            $lancamento_cpfo['debito']         = $request->debito;
        }
        if($request->credito){
            $lancamento_cpfo['credito']         = $request->credito;
        }
        $lancamento_last = Lancamento::all()->last();
        $lancamento = Lancamento::create($lancamento_cpfo);
        $lancamento->contas()->sync([$request->contas =>  ['percentual' => 100]]);
        $calculaSaldoLancamento   = Lancamento::calculaSaldo($lancamento, $lancamento_last);
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
        $ficorcamentaria_last = FicOrcamentaria::all()->last();
        $ficorcamentaria->delete();
        $calculaSaldoFicha  = FicOrcamentaria::calculaSaldo($ficorcamentaria, $ficorcamentaria_last);
        return redirect("/ficorcamentarias")->with('alert-success', 'Ficha Orçamentária excluída com sucesso!');
    }
}
