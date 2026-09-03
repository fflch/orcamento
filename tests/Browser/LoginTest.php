<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Database\Seeders\MovimentoSeeder;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_login(): void
    {
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->clicklink('Entrar')
            ->type('loginUsuario', 111111)
            ->press('Login')
            ->assertSee('Não foi possível localizar um ano ativo');
        });
    
        $movimento = new MovimentoSeeder();
        $movimento->run();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
            ->clicklink('Entrar')
            ->type('loginUsuario', 111111)
            ->press('Login')
            ->assertSee('Sair');
        });
    }
}
