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
    public function index(Request $request)
    {
        //dd($request->busca);
        if($request->busca != null){
            //$tipocontas = TipoConta::all()->sortBy('descricao');
            $tipocontas = TipoConta::where('descricao','LIKE',"%{$request->busca}%")->paginate(5);
        }
        else{
            //$tipocontas = TipoConta::all()->sortBy('descricao');
            $tipocontas = TipoConta::paginate(5);
        }        
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
    public function store(TipoContaRequest $request)
    {
        $validated = $request->validated();
        TipoConta::create($validated);
       
        //$tipoconta->user_id = \Auth::user()->id;

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
    public function update(TipoContaRequest $request, TipoConta $tipoconta)
    {
        $validated = $request->validated();
        $tipoconta->update($validated);
        
        //$tipoconta->user_id = \Auth::user()->id;

        $request->session()->flash('alert-success', 'Tipo de Conta alterado com sucesso!');
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
        return redirect()->route('tipocontas.index')->with('alert-success', 'Tipo de Conta deletado com sucesso!');
    }
}