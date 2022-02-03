<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Socialite;
use App\Models\User;
use App\Models\Movimento;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function redirectToProvider(){
        return Socialite::driver('senhaunica')->redirect();
    }

    public function handleProviderCallback(){
        $userSenhaUnica = Socialite::driver('senhaunica')->user();
        $user = User::where('codpes',$userSenhaUnica->codpes)->first();
        if (is_null($user))
            $user = new User;
        $user->codpes = $userSenhaUnica->codpes;
        $user->email = $userSenhaUnica->email;
        $user->name = $userSenhaUnica->nompes;
        $user->save();
        Auth::login($user, true);
        
        return redirect('/');
        session(['ano' => Movimento::movimento_ativo()->ano]);
    }

    public function logout(){
        Auth::logout();
        //session(['ano' => "null"]);
        return redirect('/');
    }
}
