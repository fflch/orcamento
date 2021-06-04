<?php

namespace App\Http\Controllers;

use App\Models\Conta;
use Illuminate\Http\Request;
use App\Http\Requests\ContaRequest;

use App\Models\Movimento;
use App\Models\TipoConta;
use App\Models\Area;

class ContaController extends Controller
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
            $contas = Conta::where('nome','=',$request->busca)->paginate(10);
        }
        else{
            //$contas = Conta::paginate(5)->sortByDesc('nome');
            $contas = Conta::paginate(10);
        }
        return view('contas.index')->with('contas', $contas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('all');
        $lista_tipos_contas = TipoConta::lista_tipos_contas();
        $lista_areas = Area::lista_areas();

        return view('contas.create', compact('lista_tipos_contas','lista_areas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContaRequest $request)
    {
        //$movimento_ativo = Movimento::movimento_ativo();

        $this->authorize('all');
        $validated = $request->validated();
        $validated['tipoconta_id'] = $request->tipoconta_id;
        $validated['area_id']= $request->area_id;
        $validated['ativo'] = $request->ativo;
        $validated['user_id'] = \Auth::user()->id;

        //$validated['movimento_id'] = $movimento_ativo->id;

        //$conta->tipoconta_id = $request->tipoconta_id;
        //$conta->area_id = $request->area_id;

        Conta::create($validated);

        $request->session()->flash('alert-success', 'Conta cadastrada com sucesso!');
        return redirect()->route('contas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function show(Conta $conta)
    {
        $this->authorize('all');
        return view('contas.show', compact('conta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function edit(Conta $conta)
    {
        $this->authorize('admin');
        $lista_tipos_contas = TipoConta::lista_tipos_contas();
        $lista_areas = Area::lista_areas();

        return view('contas.edit', compact('conta','lista_tipos_contas','lista_areas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function update(ContaRequest $request, Conta $conta)
    {
        $this->authorize('admin');
        //$movimento_ativo = Movimento::movimento_ativo();
        $validated = $request->validated();
        $validated['tipoconta_id'] = $request->tipoconta_id;
        $validated['area_id']= $request->area_id;
        $validated['ativo'] = $request->ativo;
        $validated['user_id'] = \Auth::user()->id;

        //$conta->movimento_id = $movimento_ativo->id;
        //$conta->tipoconta_id = $request->tipoconta_id;
        //$conta->area_id = $request->area_id;

        $conta->update($validated);
        
        $request->session()->flash('alert-success', 'Conta alterada com sucesso!');
        return redirect()->route('contas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conta  $conta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conta $conta, Request $request)
    {
        $this->authorize('admin');
        $conta->delete();
        return redirect()->route('contas.index')->with('alert-success', 'Conta deletada com sucesso!');
    }
}
