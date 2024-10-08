<?php

namespace App\Http\Controllers;

use App\Models\TipoConta;
use Illuminate\Http\Request;
use App\Http\Requests\TipoContaRequest;

class TipoContaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');
        $tipocontas = TipoConta::when($request->busca_descricao, function ($query) use ($request) {
                          return $query->where('descricao', 'LIKE', '%'.$request->busca_descricao.'%');
                      })
                      ->orderBy('descricao')
                      ->paginate(10);

        return view('tipocontas.index')->with('tipocontas', $tipocontas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->authorize('Todos');
        return view('tipocontas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TipoContaRequest $request){
        $this->authorize('Todos');
        TipoConta::create($request->validated() + [ 'user_id' => \Auth::user()->id ]);
        $request->session()->flash('alert-success', 'Tipo de Conta [ ' . $request->descricao . ' ] cadastrado com sucesso!');
        return redirect()->route('tipocontas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function show(TipoConta $tipoconta){
        $this->authorize('Todos');
        return view('tipocontas.show', compact('tipoconta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoConta $tipoconta){
        $this->authorize('Administrador');
        return view('tipocontas.edit', compact('tipoconta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function update(TipoContaRequest $request, TipoConta $tipoconta){
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $validated['cpfo'] = $request->has('cpfo');
        $validated['relatoriobalancete'] = $request->has('relatoriobalancete');
        $tipoconta->update($validated);
        /*
        $tipoconta->update([
            'descricao' => $request->descricao,
            'cpfo' => $request->has('cpfo'),
            'relatoriobalancete' => $request->has('relatoriobalancete'),
            'user_id' => \Auth::user()->id,
        ]);
        */
        $request->session()->flash('alert-success', 'Tipo de Conta [ ' . $tipoconta->descricao . ' ] alterado com sucesso!');
        return redirect()->route('tipocontas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoConta $tipoconta, Request $request){
        $this->authorize('Administrador');
        if($tipoconta->conta->isNotEmpty()){
            request()->session()->flash('alert-danger','Tipo de Conta [ ' . $tipoconta->descricao . ' ] não pode ser excluído,
            pois existem Contas cadastradas nela.');
            return redirect("/tipocontas");
        }
        $tipoconta->delete();
        return redirect()->route('tipocontas.index')->with('alert-success', 'Tipo de Conta [ ' . $tipoconta->descricao . ' ] excluído com sucesso!');
    }
}
