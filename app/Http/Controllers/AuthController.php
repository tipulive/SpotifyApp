<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Auth;
use DB;

class AuthController extends Controller
{
    //

    function __construct() {
        $this->Spotify_url = env('SPOTIFY_URL');
      }
    public function login(){
        return Socialite::driver('spotify')
        ->scopes(['user-read-email','user-read-recently-played'])//this is to grant permission to access this scopes
        ->redirect();//redirect data to Spotify to Login
    }
    public function callback(){//this callback Method will be called after User Login because this redirect link is setup on both .env variable(SPOTIFY_REDIRECT_URI) or on Spotify Developer Account to redirect user After login


            $user = Socialite::driver('spotify')->user();


        $user = User::updateOrCreate([//if User exist in users table  then update Users table using Eloquent user Model or else add new user
            'provider_id'=>$user->getId(),
        ], [
            'name'=>$user->getName(),
            'email'=>$user->getEmail(),
            'Token'=> $user->token,
            'refreshToken'=>$user->refreshToken,
            'avatar'=>$user->getAvatar()


        ]);

        Auth::login($user);//use this Auth Facades to Authenticate user

            return response([
                "result"=>true,
                "status"=>200,
                "resultData"=>[
                    "Id"=>Auth::user()->id,
                    "Name"=>Auth::user()->name,
                    "Email"=>Auth::user()->email,
                    "Avatar"=>Auth::user()->avatar,
                    "Spotify_id"=>Auth::user()->provider_id

                ],

            ],200);







    }
    public function UsersDetails(){//Get all users


            $check=DB::select("select id,email,name,avatar,provider_id as  Spotify_id from users");
            if($check)
            {
                return response([
                    "result"=>true,
                    "resultData"=>$check


                ],200);
            }
            else{
                return response([
                    "result"=>false,
                    "resultData"=>"no data Found"


                ],200);
            }




    }



    public function logout(){
        Auth::logout();
    }

}
