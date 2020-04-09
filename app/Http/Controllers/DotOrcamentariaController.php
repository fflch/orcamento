<?php

namespace App\Http\Controllers;

use App\DotOrcamentaria;
use Illuminate\Http\Request;

class DotOrcamentariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dotorcamentarias = DotOrcamentaria::all()->sortBy('dotacao');
        return view('dotorcamentarias.index')->with('dotorcamentarias', $dotorcamentarias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dotorcamentarias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // Validações
        $request->validate([
            'dotacao'        => 'numeric|required',
            //'concluido'  => 'required|numeric|min:8|max:30',
            //'ativo'      => 'numeric',
        ]);
 
        // Persistência
        $dotorcamentaria = new DotOrcamentaria;
        $dotorcamentaria->dotacao        = $request->dotacao;
        $dotorcamentaria->grupo          = $request->grupo;
        $dotorcamentaria->descricaogrupo = $request->descricaogrupo;
        $dotorcamentaria->item           = $request->item;
        $dotorcamentaria->descricaoitem  = $request->descricaoitem;
        $dotorcamentaria->receita        = $request->receita;
        
        //$dotorcamentaria->user_id = \Auth::user()->id;
        $dotorcamentaria->save();

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
        return view('dotorcamentarias.edit', compact('dotorcamentaria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DotOrcamentaria  $dotOrcamentaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DotOrcamentaria $dotorcamentaria)
    {
       // Validações
        $request->validate([
            'dotacao'        => 'numeric|required',
            //'concluido'  => 'required|numeric|min:8|max:30',
            //'ativo'      => 'numeric',
        ]);
 
        // Persistência
        $dotorcamentaria->dotacao        = $request->dotacao;
        $dotorcamentaria->grupo          = $request->grupo;
        $dotorcamentaria->descricaogrupo = $request->descricaogrupo;
        $dotorcamentaria->item           = $request->item;
        $dotorcamentaria->descricaoitem  = $request->descricaoitem;
        $dotorcamentaria->receita        = $request->receita;
        
        //$dotorcamentaria->user_id = \Auth::user()->id;
        $dotorcamentaria->save();

        $request->session()->flash('alert-success', 'Dotação Orçamentária cadastrada com sucesso!');
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
        $dotorcamentaria->delete();
        return redirect()->route('dotorcamentarias.index')->with('alert-danger', 'Dotação Orçamentária deletada!');
    }
}
