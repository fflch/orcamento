<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('Administrador', function ($user) {
            if($user->perfil == 'Administrador')
              return TRUE;
        });

        Gate::define('Todos', function ($user) {
            if(($user->perfil == 'Administrador') or ($user->perfil == 'Usuário'))
              return TRUE;
        });
    }
}
