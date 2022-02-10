<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Movimento;
use Socialite;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function redirectToProvider(){
        return Socialite::driver('senhaunica')->redirect();
    }

    public function handleProviderCallback(){
        $userSenhaUnica = Socialite::driver('senhaunica')->user();
        $user = User::where('codpes',$userSenhaUnica->codpes)->first();
        if (is_null($user))
            $user = new User;
        $user->codpes = $userSenhaUnica->codpes;
        $user->email  = $userSenhaUnica->email;
        $user->name   = $userSenhaUnica->nompes;
        $user->save();
        Auth::login($user, true);
        return redirect('/');
        session(['ano' => Movimento::movimento_ativo()->ano]);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
        session(['ano' => null]);
    }
}
