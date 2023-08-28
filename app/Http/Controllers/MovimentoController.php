<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use Illuminate\Http\Request;
use App\Http\Requests\MovimentoRequest;
use DB;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');
        $movimentos = Movimento::when($request->busca_ano, function ($query) use ($request) {
                         return $query->where('ano', '=', $request->busca_ano);
                      })
                      ->orderBy('ano')
                      ->paginate(10);

        return view('movimentos.index')->with('movimentos', $movimentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->authorize('Todos');
        return view('movimentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovimentoRequest $request){
        $this->authorize('Todos');
        if($request->ativo == 1)
            DB::table('movimentos')->update(['ativo' => 0]);
        Movimento::create( $request->validated() + ['user_id' => \Auth::user()->id] );
        $request->session()->flash('alert-success', 'Movimento [ ' . $request->ano . ' ] cadastrado com sucesso!');
        return redirect()->route('movimentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimento $movimento){
        $this->authorize('Todos');
        return view('movimentos.show', compact('movimento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimento $movimento){
        $this->authorize('Administrador');
        return view('movimentos.edit', compact('movimento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function update(MovimentoRequest $request, Movimento $movimento){
        $this->authorize('Administrador');
        if($request->ativo == 1)
            DB::table('movimentos')->update(['ativo' => 0]);
        $movimento->update([
            'ano'       => $request->ano,
            'ativo'     => $request->has('ativo'),
            'user_id'   => \Auth::user()->id,
        ]);
        $request->session()->flash('alert-success', 'Movimento [ ' . $movimento->ano . ' ] alterado com sucesso!');
        return redirect()->route('movimentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimento $movimento, Request $request){
        $this->authorize('Administrador');
        if($movimento->lancamento->isNotEmpty()){
            request()->session()->flash('alert-danger','Movimento [ ' . $movimento->ano . ' ] não pode ser excluído,
            pois existem Lançamentos cadastrados nele.');
            return redirect("/movimentos");
        }
        if($movimento->ficha_orcamentaria->isNotEmpty()){
            request()->session()->flash('alert-danger','Movimento [ ' . $movimento->ano . ' ] não pode ser excluído,
            pois existem lançamentos da Ficha Orçamentária cadastrados nele.');
            return redirect("/movimentos");
        }
        $movimento->delete();
        return redirect()->route('movimentos.index')->with('alert-success', 'Movimento [ ' . $movimento->ano . ' ] excluído com sucesso!');
    }
}
