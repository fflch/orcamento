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
            $tipocontas = TipoConta::where('descricao','LIKE',"%{$request->busca}%")->paginate(10);
        }
        else{
            //$tipocontas = TipoConta::all()->sortBy('descricao');
            $tipocontas = TipoConta::paginate(10);
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
        /*SEM TipoContaRequest
        if($request->cpfo != 1)
            $request->cpfo = 0;

        if($request->relatoriobalancete != 1)
            $request->relatoriobalancete = 0;

        $tipoconta = new TipoConta;
        $tipoconta->descricao = $request->descricao;
        $tipoconta->cpfo = $request->cpfo;
        $tipoconta->relatoriobalancete = $request->relatoriobalancete;
        $tipoconta->user_id = \Auth::user()->id;
        $tipoconta->save();*/
                
        /*COM TipoContaRequest*/
        $validated = $request->validated();
        $validated['cpfo'] = $request->cpfo;
        $validated['relatoriobalancete'] = $request->relatoriobalancete;
        $validated['user_id'] = \Auth::user()->id;
        TipoConta::create($validated);
       
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
        /*SEM TipoContaRequest
        if($request->cpfo != 1)
            $request->cpfo = 0;

        if($request->relatoriobalancete != 1)
            $request->relatoriobalancete = 0;

        $tipoconta->descricao = $request->descricao;
        $tipoconta->cpfo = $request->cpfo;
        $tipoconta->relatoriobalancete = $request->relatoriobalancete;
        $tipoconta->user_id = \Auth::user()->id;
        $tipoconta->save();*/


        /*COM TipoContaRequest*/
        $validated = $request->validated();
        $validated['cpfo'] = $request->cpfo;
        $validated['relatoriobalancete'] = $request->relatoriobalancete;
        $validated['user_id'] = \Auth::user()->id;
        $tipoconta->update($validated);
        
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