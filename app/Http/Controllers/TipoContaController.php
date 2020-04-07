<?php

namespace App\Http\Controllers;

use App\TipoConta;
use Illuminate\Http\Request;

class TipoContaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipocontas = TipoConta::all()->sortBy('descricao');
        return view('tipocontas.index')->with('tipocontas', $tipocontas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tipocontas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'descricao'        => 'required',
        ]);
 
        $tipoconta = new TipoConta;
        $tipoconta->descricao          = $request->descricao;
        $tipoconta->cpfo               = $request->cpfo;
        $tipoconta->relatoriobalancete = $request->relatoriobalancete;
        
        //$tipoconta->user_id = \Auth::user()->id;
        $tipoconta->save();

        $request->session()->flash('alert-success', 'Tipo de Conta cadastrado com sucesso!');
        return redirect()->route('tipocontas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function show(TipoConta $tipoconta)
    {
        return view('tipocontas.show', compact('tipoconta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function edit(TipoConta $tipoconta)
    {
        return view('tipocontas.edit', compact('tipoconta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoConta $tipoconta)
    {
        $request->validate([
            'descricao'        => 'required',
        ]);
 
        $tipoconta->descricao          = $request->descricao;
        $tipoconta->cpfo               = $request->cpfo;
        $tipoconta->relatoriobalancete = $request->relatoriobalancete;
        
        //$tipoconta->user_id = \Auth::user()->id;
        $tipoconta->save();

        $request->session()->flash('alert-success', 'Tipo de Conta cadastrado com sucesso!');
        return redirect()->route('tipocontas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TipoConta  $tipoConta
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoConta $tipoconta)
    {
        $tipoconta->delete();
        return redirect()->route('tipocontas.index')->with('alert-danger', 'Tipo de Conta deletado!');
    }
}