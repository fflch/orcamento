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
    public function index(Request $request){
        $this->authorize('Todos');
        if($request->busca_texto != null){
            $notas = Nota::where('texto','LIKE','%'.$request->busca_texto.'%')
                         ->orderBy('tipo',)
                         ->orderBy('texto')
                         ->paginate(10);
        }else{
            $notas = Nota::orderBy('tipo',)
                         ->orderBy('texto')
                         ->paginate(10);
        }
        return view('notas.index')->with('notas', $notas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->authorize('Todos');
        return view('notas.create', [
            'nota'               => new Nota,
            'lista_tipos_contas' => TipoConta::lista_tipos_contas(),
            'lista_tipos'        => Nota::lista_tipos(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotaRequest $request){
        $this->authorize('Todos');
        $validated = $request->validated();
        $validated['user_id']      = auth()->user()->id;
        $validated['tipoconta_id'] = $request->tipoconta_id;
        Nota::create($validated);
        $request->session()->flash('alert-success', 'Nota [ ' . $request->texto . ' ] cadastrada com sucesso!');
        return redirect()->route('notas.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show(Nota $nota){
        $this->authorize('Todos');
        return view('notas.show', compact('nota'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit(Nota $nota){
        $this->authorize('Administrador');
        return view('notas.edit', [
                    'nota'               => $nota,
                    'lista_tipos_contas' => TipoConta::lista_tipos_contas(),
                    'lista_tipos'        => Nota::lista_tipos(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(NotaRequest $request, Nota $nota){
        $this->authorize('Administrador');
        $validated            = $request->validated();
        $validated['user_id'] = auth()->user()->id;
        $nota->tipoconta_id   = $request->tipoconta_id;
        $nota->update($validated);
        $request->session()->flash('alert-success', 'Nota [ ' . $nota->texto . ' ] alterada com sucesso!');
        return redirect()->route('notas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nota $nota){
        $this->authorize('Administrador');
        $nota->delete();
        return redirect()->route('notas.index')->with('alert-success', 'Nota [ ' . $nota->texto . ' ] excluída com sucesso!');
    }
}
