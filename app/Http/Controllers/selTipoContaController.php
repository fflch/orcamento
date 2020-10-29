<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class selTipoContaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    public function seltipoconta(){
        return view('selTipoConta');
    }
}
