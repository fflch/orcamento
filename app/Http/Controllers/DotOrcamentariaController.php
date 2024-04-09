<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\DotOrcamentaria;
use App\Models\FicOrcamentaria;
use App\Models\Movimento;
use Illuminate\Http\Request;
use App\Http\Requests\DotOrcamentariaRequest;

class DotOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');
        $dotorcamentarias = DotOrcamentaria::
            when($request->busca_dotacao, function ($query) use ($request) {
                return $query->where('dotacao', '=', $request->busca_dotacao);
            })
            ->when($request->busca_grupo, function ($query) use ($request) {
                return $query->where('grupo', '=', $request->busca_grupo);
            })
            ->orderBy('dotacao')
            ->paginate(10);

        return view('dotorcamentarias.index')->with('dotorcamentarias', $dotorcamentarias);
    }

    public function fichas_por_dotacao(DotOrcamentaria $dotorcamentaria){

        $this->authorize('Todos');

        $movimento = Movimento::where('ano', session('ano'))->first();

        $fichas = FicOrcamentaria::where('dotacao_id', $dotorcamentaria->id)
                                   ->where('movimento_id', $movimento->id)
                                   ->get();

        $hoje = Carbon::now()->format('m/d/Y');

        return view('ficorcamentarias.index_por_dotacao',[
                    'fichas'              => $fichas,
                    'dotorcamentaria'     => $dotorcamentaria,
                    'hoje'                => $hoje,
                    'total_debito'        => $fichas->sum('debito_raw'),
                    'total_credito'       => $fichas->sum('credito_raw'),
                    'movimento_anos'      => Movimento::movimento_anos()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->authorize('Todos');
        return view('dotorcamentarias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DotOrcamentariaRequest $request){
        $this->authorize('Todos');
        DotOrcamentaria::create($request->validated() + ['user_id' => \Auth::user()->id ]);
        $request->session()->flash('alert-success', 'Dotação Orçamentária [ ' . $request->dotacao . ' ] cadastrada com sucesso!');
        return redirect()->route('dotorcamentarias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function show(DotOrcamentaria $dotorcamentaria){
        $this->authorize('Todos');
        return view('dotorcamentarias.show', compact('dotorcamentaria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function edit(DotOrcamentaria $dotorcamentaria){
        $this->authorize('Administrador');
        return view('dotorcamentarias.edit', compact('dotorcamentaria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function update(DotOrcamentariaRequest $request, DotOrcamentaria $dotorcamentaria){
        $this->authorize('Administrador');
        $dotorcamentaria->update($request->validated() + ['user_id' => \Auth::user()->id] );
        $request->session()->flash('alert-success', 'Dotação Orçamentária [ ' . $dotorcamentaria->dotacao . ' ] alterada com sucesso!');
        return redirect()->route('dotorcamentarias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(DotOrcamentaria $dotorcamentaria){
        $this->authorize('Administrador');
        if($dotorcamentaria->ficha_orcamentaria->isNotEmpty()){
            request()->session()->flash('alert-danger','Dotação Orçamentária [ ' . $dotorcamentaria->dotacao . ' ] não pode ser excluída, 
            pois existem lançamentos da Ficha Orçamentária cadastrados nela.');
            return redirect("/dotorcamentarias");    
        }
        $dotorcamentaria->delete();
        return redirect()->route('dotorcamentarias.index')->with('alert-success', 'Dotação Orçamentária [ ' . $dotorcamentaria->dotacao . ' ] excluída com sucesso!');
    }
}
