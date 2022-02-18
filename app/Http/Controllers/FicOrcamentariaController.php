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
        if($request->dotacao_id != null)
            $ficorcamentarias = FicOrcamentaria::where('dotacao_id','=',$request->dotacao_id)->orderBy('data')->paginate(10);
        else
            $ficorcamentarias = FicOrcamentaria::orderBy('data')->paginate(10);
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
        //$lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias_ativas();
        //$lista_descricoes       = Nota::lista_descricoes();
        //$lista_observacoes      = Nota::lista_observacoes();
        //$lista_tipos_contas     = TipoConta::lista_tipos_contas();
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
    public function cpfo(FicOrcamentariaRequest $request){
        //dd($request);
        $this->authorize('Todos');
        $chaves  = array_keys($request->tipocontaid_quantidades);
        $valores = array_values($request->tipocontaid_quantidades   );
        $novos_valores = [];
        foreach($chaves as $chave){
            $descricao_conta = TipoConta::descricao_tipo_conta($chave);
            $valor = $descricao_conta;
            array_push($novos_valores, $valor);
        }

        $dotorcamentaria = DotOrcamentaria::dotacao($request->dotacao_id);
        //dd($dotorcamentaria[0]->grupo);


        //dd($novos_valores);

        /*return redirect()->route('ficorcamentarias.contrapartida', 
        compact('request_FO',
                'tipocontaid_quantidades',
                'tipocontaid_descricaoconta',
                'lista_contas'));*/

        return view('ficorcamentarias.contrapartida',[ 
                    'request_FO'                 => $request,
                    'tipocontaid_quantidades'    => $request->tipocontaid_quantidades,
                    'tipocontaid_descricaoconta' => array_combine($chaves,$novos_valores),
                    'lista_contas_ativas'        => Conta::lista_contas_ativas(),
                    'dotorcamentaria'            => DotOrcamentaria::dotacao($request->dotacao_id),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FicOrcamentariaCPRequest $request){
    //public function store(Request $request){
        $this->authorize('Todos');
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
        $fichaorcamentaria['movimento_id'] = Movimento::movimento_ativo()->id;
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
                $lancamento['movimento_id']       = Movimento::movimento_ativo()->id;        
                Lancamento::create($lancamento);
            }
        }
        $calculaSaldoFichaOrcamentaria  = FicOrcamentaria::calculaSaldo($request->dotacao_id);
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
        if($request->debito == null)
            $validated['debito']  = 0.00;
        if($request->credito == null)
            $validated['credito'] = 0.00;
        $validated['user_id']          = auth()->user()->id;
        $ficorcamentaria->user_id      = auth()->user()->id;
        $ficorcamentaria->movimento_id = Movimento::movimento_ativo()->id;
        $ficorcamentaria->dotacao_id   = $request->dotacao_id;
        $ficorcamentaria->update($validated);
        $calculaSaldoFichaOrcamentaria  = FicOrcamentaria::calculaSaldo($ficorcamentaria->dotacao_id);
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
        $calculaSaldoFichaOrcamentaria = FicOrcamentaria::calculaSaldo($ficorcamentaria->dotacao_id);
        return redirect()->route('ficorcamentarias.index')
                         ->with('alert-success', 'Ficha Orçamentária excluída com sucesso!');
    }
}
