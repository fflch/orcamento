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
        //dd(session('ano'));
        if(auth()->user()){
            $perfil_logado = auth()->user()->perfil;
            if (session('ano') == null) {
                session(['ano' => Movimento::movimento_ativo()->ano]);
            }
        }
        else{
            $perfil_logado = '';
        }
        return view('index',[
                    'movimento_ativo' => Movimento::movimento_ativo(),
                    'perfil_logado'   => $perfil_logado,
                    'movimento_anos'  => Movimento::movimento_anos(),
        ]);
    }

    public function mudaAno(Request $request){
        //dd($request);
        $this->authorize('Todos');
        /*
        # A validação ainda precisa passar para um local mais apropriado
        $validator = Validator::make(['ano' => $request->ano], [
            'ano' => 'required|integer|in:' . implode(',', Movimento::anos()),
        ]);

        if ($validator->fails()) {
            return back()
                 ->withErrors($validator)
                 ->withInput();
        }
        */
        session(['ano' => $request->ano]);
        return back();
    }
}
