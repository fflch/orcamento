<?php

namespace App\Http\Controllers;

use App\Models\DotOrcamentaria;
use Illuminate\Http\Request;
use App\Http\Requests\DotOrcamentariaRequest;

class DotOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('Todos');
        if($request->busca != null){
            $dotorcamentarias = DotOrcamentaria::where('dotacao','=',$request->busca)->orderBy('dotacao')->paginate(10);
        }
        else{
            //$dotorcamentarias = DotOrcamentaria::all()->sortBy('dotacao');
            $dotorcamentarias = DotOrcamentaria::orderBy('dotacao')->paginate(10);
        }       
        return view('dotorcamentarias.index')->with('dotorcamentarias', $dotorcamentarias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Todos');
        return view('dotorcamentarias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DotOrcamentariaRequest $request)
    {
        $this->authorize('Todos');
        $validated = $request->validated();
        $validated['receita'] = $request->receita;
        $validated['ativo']   = $request->ativo;
        $validated['user_id'] = \Auth::user()->id;
        DotOrcamentaria::create($validated);
  
        $request->session()->flash('alert-success', 'Dotação Orçamentária cadastrada com sucesso!');
        return redirect()->route('dotorcamentarias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function show(DotOrcamentaria $dotorcamentaria)
    {
        $this->authorize('Todos');
        return view('dotorcamentarias.show', compact('dotorcamentaria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function edit(DotOrcamentaria $dotorcamentaria)
    {
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
    public function update(DotOrcamentariaRequest $request, DotOrcamentaria $dotorcamentaria)
    {
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['receita'] = $request->receita;
        $validated['ativo']   = $request->ativo;
        $validated['user_id'] = \Auth::user()->id;
        $dotorcamentaria->update($validated);
        
        $request->session()->flash('alert-success', 'Dotação Orçamentária alterada com sucesso!');
        return redirect()->route('dotorcamentarias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(DotOrcamentaria $dotorcamentaria)
    {
        $this->authorize('Administrador');
        $dotorcamentaria->delete();
        return redirect()->route('dotorcamentarias.index')->with('alert-success', 'Dotação Orçamentária deletada com sucesso!');
    }
}
