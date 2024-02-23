<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use \Spatie\Permission\Traits\HasRoles;
    use \Uspdev\SenhaunicaSocialite\Traits\HasSenhaunica;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'perfil',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function lista_usuarios(){
        $lista_usuarios = User::where('perfil','!=','Nenhum')->orderBy('name')->get();
        return $lista_usuarios;
    }

    public function conta_usuarios(){
        return $this->belongsToMany(Conta::class,'conta_usuarios', 'id_conta', 'id_usuario')
            ->using(ContaUsuario::class)
            ->withTimestamps()
            ->withPivot([
                'created_at'
            ]);
    }

    public static function lista_perfis(){
        return[
            'Administrador',
            'Usuário',
            'Nenhum',
        ];
    }

    public static function perfil_logado(){
        $perfil_logado = User::where('id','=',auth()->user()->id);
        return $perfil_logado;    
    }
}
