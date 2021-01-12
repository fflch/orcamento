<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function contas_usuarios(Request $request, User $usuario){
        $user = User::find($request->user_id);
        $usuario->emprestimos()->attach($user);
        return redirect('/usuarios/' . $usuario->id);
    }
}
