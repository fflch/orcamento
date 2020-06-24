<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;

class MovimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$movimentos = Movimento::paginate(5)->sortByDesc('ano');
        $movimentos = Movimento::paginate(5);
        return view('movimentos.index')->with('movimentos', $movimentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movimentos.create');
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
            'ano'        => 'numeric|required',
            //'concluido'  => 'required|numeric|min:8|max:30',
            //'ativo'      => 'numeric',

        ]);
 
        // Persistência
        $movimento = new Movimento;
        $movimento->ano       = $request->ano;
        $movimento->concluido = $request->concluido;
        $movimento->ativo     = $request->ativo;
        
        //$movimento->user_id = \Auth::user()->id;
        $movimento->save();

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
        //return view('movimentos.edit');
        return view('movimentos.edit', compact('movimento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movimento  $movimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movimento $movimento)
    {
       // Validações
        $request->validate([
            'ano'        => 'numeric|required',
            //'concluido'  => 'required|numeric|min:8|max:30',
            //'ativo'      => 'numeric',

        ]);
 
        // Persistência
        //$movimento = new Movimento;
        $movimento->ano       = $request->ano;
        $movimento->concluido = $request->concluido;
        $movimento->ativo     = $request->ativo;
        
        //$movimento->user_id = \Auth::user()->id;
        $movimento->save();

        $request->session()->flash('alert-success', 'Movimento cadastrado com sucesso!');
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
        $movimento->delete();
        return redirect()->route('movimentos.index')->with('alert-danger', 'Movimento deletado!');
    }
}