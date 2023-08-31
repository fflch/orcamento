<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class indexController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['index']);
    }

    public function index(){

        $perfil_logado = '';
        $movimento_ativo = null;
        if(auth()->user()){
            $perfil_logado = auth()->user()->perfil;
            $movimento_ativo = Movimento::movimento_ativo()->ano;
            if (session('ano') == null) {
                session(['ano' => $movimento_ativo]);
            }
        }
        return view('index',[
                    'movimento_ativo' => $movimento_ativo,
                    'perfil_logado'   => $perfil_logado,
                    'movimento_anos'  => Movimento::movimento_anos(),
        ]);
    }

    public function mudaAno(Request $request){
        $this->authorize('Todos');

        # A validação ainda precisa passar para um local mais apropriado
        $validator = Validator::make(['ano' => $request->ano], [
            'ano' => 'required|integer|in:' . implode(',', Movimento::anos()),
        ]);

        if ($validator->fails()) {
            return back()
                 ->withErrors($validator)
                 ->withInput();
        }

        session(['ano' => $request->ano]);
        return back();
    }
}
