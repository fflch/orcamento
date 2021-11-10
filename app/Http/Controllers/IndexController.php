<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use App\Models\User;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(){
        $movimento_ativo = Movimento::movimento_ativo();
        if(auth()->user()){
            $perfil_logado   = auth()->user()->perfil;
        }
        else{
            $perfil_logado = '';
        }
        return view('index', compact('movimento_ativo','perfil_logado'));
    }
}
