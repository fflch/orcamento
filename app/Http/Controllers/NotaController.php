<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use App\Models\TipoConta;
use App\Http\Requests\NotaRequest;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       if($request->busca != null){
        //$notas = Nota::paginate(5)->sortByDesc('texto');
        $notas = Nota::where('texto','LIKE','%'.$request->busca.'%')->paginate(5);
    }
        else{
            //$notas = Nota::paginate(5)->sortByDesc('texto');
            $notas = Nota::paginate(5);
        }
        return view('notas.index')->with('notas', $notas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lista_tipos_contas = TipoConta::lista_tipos_contas();

        return view('notas.create', compact('lista_tipos_contas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotaRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        //$nota->tipoconta_id = $request->tipoconta_id;
        $validated['tipoconta_id'] = $request->tipoconta_id;
        //$nota->area_id = $request->area_id;
        //dd($validated);

        Nota::create($validated);

        $request->session()->flash('alert-success', 'Nota cadastrada com sucesso!');
        return redirect()->route('notas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show(Nota $nota)
    {
        return view('notas.show', compact('nota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit(Nota $nota)
    {
        $lista_tipos_contas = TipoConta::lista_tipos_contas();

        return view('notas.edit', compact('nota','lista_tipos_contas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(NotaRequest $request, Nota $nota)
    {
        $validated = $request->validated();
        //dd(auth()->user()->id);
        $validated['user_id'] = auth()->user()->id;
        //dd($validated);

        $nota->tipoconta_id = $request->tipoconta_id;

        $nota->update($validated);
        
        $request->session()->flash('alert-success', 'Nota alterada com sucesso!');
        return redirect()->route('notas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota)
    {
        $nota->delete();
        return redirect()->route('notas.index')->with('alert-success', 'Nota deletada com sucesso!!');
    }
}
