<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use App\Http\Requests\UnidadeRequest;

class UnidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Todos');
        $unidades = Unidade::all();
        return view('unidades.index')->with('unidades', $unidades);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function show(Unidade $unidade)
    {
        $this->authorize('Todos');
        return view('unidades.show', compact('unidade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        $this->authorize('Administrador');
        return view('unidades.edit', compact('unidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(UnidadeRequest $request, Unidade $unidade)
    {
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['user_id'] = \Auth::user()->id;
        $unidade->update($validated);
        
        $request->session()->flash('alert-success', 'Unidade alterada com sucesso!');
        return redirect()->route('unidades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        //
    }
}
