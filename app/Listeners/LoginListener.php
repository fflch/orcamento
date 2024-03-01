<?php

namespace App\Listeners;

use App\Models\Movimento;
use Illuminate\Auth\Events\Login;
use Auth;
use Session;
use  App\Services\MovimentoService;

class LoginListener
{

    public function __construct()
    {
    }

    public function handle(Login $event)
    {
        $user = $event->user;
        $movimento_ativo = MovimentoService::handle($user);
        if ($movimento_ativo) {
            session(['ano' => $movimento_ativo->ano]);
            return redirect('/');
        } else {
            Session::flash('alert-danger', 'Não foi possível localizar um ano ativo, portanto, o login no sistema está indisponível.
            Entre em contato com o Serviço de Contabilidade.');
            auth()->logout();
            return redirect('/');        
        }
    }
}