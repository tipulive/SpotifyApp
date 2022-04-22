<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;

class TestController extends Controller
{
    //
    public function testLogin(){

        return Socialite::driver('spotify')
        ->scopes(['user-read-email'])
        ->redirect();
    }


    public function callback(){
        //$user = Socialite::driver('spotify')->user();
        //$user = Socialite::driver('spotify')->stateless()->user();
        //$user = "Socialite::driver('spotify')->user()";
        //dd($user->getAvatar());
       // dd($user->getId());
        //$user->getAvatar());
        $user = Socialite::driver('spotify')->user();
        dd($user);
    }
}
