<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function contas_usuarios(Request $request, User $usuario){
        $user = User::find($request->user_id);
        $usuario->user()->attach($user);
        return redirect('/usuarios/' . $usuario->id);
    }

    public function index(Request $request){
        $this->authorize('Todos');
        if($request->busca_nome != null){
            $usuarios = User::where('name','LIKE','%'.$request->busca_nome.'%')->orderBy('name')->paginate(10);
        }
        else{
            $usuarios = User::orderBy('name')->paginate(10);
        }
        return view('usuarios.index')->with('usuarios', $usuarios);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario){
        $this->authorize('Todos');
        return view('usuarios.show', compact('usuario'));
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario){
        $this->authorize('Administrador');
        $lista_perfis = User::lista_perfis();
        return view('usuarios.edit', compact('usuario','lista_perfis'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $usuario){
        $this->authorize('Administrador');
        $validated = $request->validated();
        $validated['user_id'] = \Auth::user()->id;
        $usuario->update($validated);
        $request->session()->flash('alert-success', 'Usuário alterado com sucesso!');
        return redirect()->route('usuarios.index');
    }
}
