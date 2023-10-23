<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Conta;
use App\Models\ContaUsuario;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ContaUsuarioRequest;

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
            $usuarios = User::where('name','LIKE','%'.$request->busca_nome.'%')
                            ->orderBy('name')
                            ->paginate(10);
        } else {
            $usuarios = User::orderBy('name')
                            ->paginate(10);
        }
        return view('usuarios.index')->with('usuarios', $usuarios);
    }

    public function storeContaUsuario(ContaUsuarioRequest $request){
        $this->authorize('Todos');
        foreach($request->contaid as $id){
                $validated = $request->validated();
                $validated['id_conta']   = $id;
                $validated['user_id']    = \Auth::user()->id;
                ContaUsuario::create($validated);
        }
        $request->session()->flash('alert-success', 'Conta x Usuário cadastrada com sucesso!');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario){
        $this->authorize('Todos');
        return view('usuarios.show', [
            'usuario' => $usuario                    
        ]);
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $usuario
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario){

        $contas = ContaUsuario::where('id_usuario', $usuario->id)->paginate(5);

        $this->authorize('Administrador');
        return view('usuarios.edit', [
            'contas'   => $contas,
            'usuario'      => $usuario,
            'lista_perfis' => User::lista_perfis(),
            'lista_contas_ativas' => Conta::lista_contas_ativas()
        ]);
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
        $request->session()->flash('alert-success', 'Perfil do usuário [ ' . $usuario->name . ' ] alterado com sucesso para [ ' . $usuario->perfil . ' ]!');
        return back();
    }

    public function destroyContaUsuario(ContaUsuario $conta){
        $this->authorize('Administrador');
        $conta->delete();
        return back()->with('alert-success', 'Conta x Usuário excluída com sucesso!');
    }
}
