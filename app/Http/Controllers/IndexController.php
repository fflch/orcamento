<?php

namespace App\Http\Controllers;

use App\Models\Movimento;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function index(){
        $movimento_ativo = Movimento::movimento_ativo();
        return view('index', compact('movimento_ativo'));
    }
}
