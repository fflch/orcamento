<?php

namespace App\Http\Controllers;

use App\Models\ContaUsuario;
use App\Models\Conta;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ContaUsuarioRequest;


class ContaUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $this->authorize('Todos');
        if($request->busca != null){
            //$contausuarios = ContaUsuario::paginate(5)->sortByDesc('nome');
            $contausuarios = ContaUsuario::where('id_usuario','=',$request->busca)->paginate(10);
        }
        else{
            //$contausuarios = ContaUsuario::paginate(5)->sortByDesc('nome');
            $contausuarios = ContaUsuario::paginate(10);
        }
        return view('contausuarios.index')->with('contausuarios', $contausuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $this->authorize('Todos');
        $lista_contas_ativas = Conta::lista_contas_ativas();
        $lista_usuarios = User::lista_usuarios();

        //return view('contausuarios.create', compact('lista_contas_ativas','lista_usuarios'));
        return view('contausuarios.edit', [
            'contausuario'        => new ContaUsuario,
            'lista_contas_ativas' => $lista_contas_ativas,
            'lista_usuarios'      => $lista_usuarios,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContaUsuarioRequest $request){
        $this->authorize('Todos');
        //dd($request->contaid);
        
        foreach($request->contaid as $id){
            //dd($id);
            $validated = $request->validated();
            $validated['id_conta']   = $id;
            $validated['id_usuario'] = $request->id_usuario;
            $validated['user_id']    = \Auth::user()->id;
            ContaUsuario::create($validated);
        }

        $request->session()->flash('alert-success', 'Conta x Usuário cadastrada com sucesso!');
        return redirect()->route('contausuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ContaUsuario  $contausuario
     * @return \Illuminate\Http\Response
     */
    public function show(ContaUsuario $contausuario){
        $this->authorize('Todos');
        return view('contausuarios.show', compact('contausuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ContaUsuario  $contausuario
     * @return \Illuminate\Http\Response
     */
    public function edit(ContaUsuario $contausuario){
        $this->authorize('Administrador');
        $lista_contas_ativas = Conta::lista_contas_ativas();
        $lista_usuarios      = User::lista_usuarios();

        return view('contausuarios.edit', [
            'contausuario'        => $contausuario,
            'lista_contas_ativas' => $lista_contas_ativas,
            'lista_usuarios'      => $lista_usuarios,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ContaUsuario  $contausuario
     * @return \Illuminate\Http\Response
     */
    public function update(ContaUsuarioRequest $request, ContaUsuario $contausuario){
        $this->authorize('Administrador');
        $validated = $request->validated();
        $contausuario->id_conta = $request->id_conta;
        $contausuario->id_usuario = $request->id_usuario;
        $validated['user_id'] = \Auth::user()->id;
        $contausuario->update($validated);
        
        $request->session()->flash('alert-success', 'Conta x Usuário alterada com sucesso!');
        return redirect()->route('contausuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ContaUsuario  $contausuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContaUsuario $contausuario){
        $this->authorize('Administrador');
        $contausuario->delete();
        return redirect()->route('contausuarios.index')->with('alert-success', 'Conta x Usuário deletada com sucesso!');

    }
}
