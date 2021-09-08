<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use Illuminate\Http\Request;
use App\Http\Requests\MovimentoRequest;

class MovimentoController extends Controller
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
            $movimentos = Movimento::where('ano','=',$request->busca)->paginate(10);
        }
        else{
            //$movimentos = Movimento::paginate(5)->sortByDesc('ano');
            $movimentos = Movimento::paginate(10);
        }
        return view('movimentos.index')->with('movimentos', $movimentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Todos');
        return view('movimentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovimentoRequest $request)
    {
        $this->authorize('Todos');
        $validated = $request->validated();
        $validated['concluido'] =  $request->concluido;
        $validated['ativo'] = $request->ativo;
        $validated['user_id'] = \Auth::user()->id;
        Movimento::create($validated);

        $request->session()->flash('alert-success', 'Movimento cadastrado com sucesso!');
        return redirect()->route('movimentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function show(Movimento $movimento)
    {
        $this->authorize('Todos');
        return view('movimentos.show', compact('movimento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function edit(Movimento $movimento)
    {
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
    public function update(MovimentoRequest $request, Movimento $movimento)
    {
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['concluido'] =  $request->concluido;
        $validated['ativo'] = $request->ativo;
        $movimento->user_id = \Auth::user()->id;
        $movimento->update($validated);

        $request->session()->flash('alert-success', 'Movimento alterado com sucesso!');
        return redirect()->route('movimentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movimento $movimento, Request $request)
    {
        $this->authorize('Administrador');
        $movimento->delete();
        return redirect()->route('movimentos.index')->with('alert-success', 'Movimento deletado com sucesso!!');
    }
}