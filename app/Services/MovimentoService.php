<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Movimento;

class MovimentoService
{
    /**
     * Register services.
     *
     * @return void
     */
    public static function handle($user)
    {
        $ano = Carbon::now()->year;
        $movimento = Movimento::where('ano', $ano)->first();
        if($movimento){
            if($movimento->ativo != 1){
                $movimento = Movimento::where('ano', $ano)->update([
                    'ativo' => 1
                ]);
            }
            return $movimento;
        } elseif($user->perfil == "Administrador"){
                $movimento = Movimento::create([
                    'ano' => $ano,
                    'ativo' => 1,
                    'user_id' => $user->id
                ]);
                return $movimento;
            }
    }

    # retorna o ano do movimento da sessao
    public static function anomovimento()
    {
        return Movimento::where('ano', session('ano'))->first();
    }

}
