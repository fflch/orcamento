<?php

namespace App\Http\Controllers;

use App\Models\FicOrcamentaria;
use App\Models\DotOrcamentaria;
use App\Models\Nota;
use App\Models\Movimento;

use Illuminate\Http\Request;
use App\Http\Requests\FicOrcamentariaRequest;


class FicOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('all');
        if($request->busca != null){
            $ficorcamentarias = FicOrcamentaria::where('descricao','LIKE','%'.$request->busca.'%')->paginate(10);
        }
        else{
            //$ficorcamentarias = FicOrcamentaria::paginate(5)->sortByDesc('nome');
            //$ficorcamentarias = FicOrcamentaria::paginate(10);
            $ficorcamentarias = FicOrcamentaria::All();
        }

        $total_debito  = 0.00;
        $total_credito = 0.00;
        foreach($ficorcamentarias as $ficorcamentaria){
            $total_debito  = $total_debito + $ficorcamentaria->debito;
            $total_credito = $total_credito + $ficorcamentaria->credito;
        }

        return view('ficorcamentarias.index', compact('ficorcamentarias','total_debito','total_credito'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('all');
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();
        return view('ficorcamentarias.create', compact('lista_dotorcamentarias','lista_descricoes','lista_observacoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FicOrcamentariaRequest $request)
    {
        $this->authorize('all');
        $movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $validated['movimento_id'] = $movimento_ativo->id;

        //$ficorocamentaria->dotacao_id = $request->dotacao_id;
        $validated['dotacao_id'] = $request->dotacao_id;

        FicOrcamentaria::create($validated);

        $request->session()->flash('alert-success', 'Ficha Orçamentária cadastrada com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function show(FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('all');
        return view('ficorcamentarias.show', compact('ficorcamentaria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function edit(FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('admin');
        $lista_dotorcamentarias = DotOrcamentaria::lista_dotorcamentarias();
        $lista_descricoes = Nota::lista_descricoes();
        $lista_observacoes = Nota::lista_observacoes();

        return view('ficorcamentarias.edit', compact('ficorcamentaria','lista_dotorcamentarias','lista_descricoes','lista_observacoes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function update(FicOrcamentariaRequest $request, FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('admin');
        $movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $ficorcamentaria->user_id = auth()->user()->id;
        $ficorcamentaria->movimento_id = $movimento_ativo->id;
        $ficorcamentaria->dotacao_id = $request->dotacao_id;

        $ficorcamentaria->update($validated);
        
        $request->session()->flash('alert-success', 'Ficha Orçamentária alterada com sucesso!');
        return redirect()->route('ficorcamentarias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FicOrcamentaria  $ficorcamentaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(FicOrcamentaria $ficorcamentaria)
    {
        $this->authorize('admin');
        $ficorcamentaria->delete();
        return redirect()->route('ficorcamentarias.index')->with('alert-success', 'Ficha Orçamentária deletada com sucesso!');
    }
}
