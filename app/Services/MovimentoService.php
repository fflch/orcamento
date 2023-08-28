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
    public function handle($user)
    {
        $ano = Carbon::now()->year;
        $movimento = Movimento::where('ano', $ano)->first();
        if($movimento){
            if($movimento->ativo != 1){
                $movimento_ativo = Movimento::where('ano', $ano)->update([
                    'ativo' => 1
                ]);
            }
            return $movimento_ativo;
        } elseif($user->perfil == "Administrador"){
                $movimento_ativo = Movimento::create([
                    'ano' => $ano,
                    'ativo' => 1,
                    'user_id' => $user->id
                ]);
                return $movimento_ativo;   
            } 
          
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
