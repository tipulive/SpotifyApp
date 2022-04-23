<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Listening;


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
    public function Users(){//Get all users

        if(Auth::check())
        {
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
        else{
            return response([
                "result"=>false,
                "status"=>"403",
                "message"=>"unauthenticated Please Login",

            ],201);
        }


    }
    public function userStore_listening(){//Store on table Listening and print response object
        if(Auth::check())
        {

            $response = Http::withToken(Auth::user()->Token)//use Http client with Bear Token come From Authenticate User to get recently-played
                       ->get("{$this->Spotify_url}/v1/me/player/recently-played");

        Listening::updateOrCreate([//use Listening Model to Add new Data or update when Data is available
            'user_id'=>Auth::user()->provider_id,
            'played_at'=>$response->object()->items[0]->played_at,
        ], [
            'artist_id'=>$response->object()->items[0]->track->artists[0]->id,
            'spotify_track_id'=>$response->object()->items[0]->track->id,
            'track_name'=>$response->object()->items[0]->track->name,

        ]);
        return response([
            "result"=>true,
            "status"=>200,
            "resultData"=>$response->object(),


        ],200);

        }
        else{
            return response([
                "result"=>false,
                "status"=>"403",
                "message"=>"unauthenticated Please Login",

            ],201);
        }
    }
    public function user_listening(){//Get all recently played track from tables

        if(Auth::check())
        {
            $check=DB::select("select id, user_id, artist_id, spotify_track_id, track_name,played_at from listenings");
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
        else{
            return response([
                "result"=>false,
                "status"=>"403",
                "message"=>"unauthenticated Please Login",

            ],201);
        }


    }
    public function UpdateToken(Request $request){//Get new Token using Refresh Token come From table

        $url  = "https://accounts.spotify.com/api/token";
        $data = [
        "client_id"=> env('SPOTIFY_CLIENT_ID'),
        "client_secret" =>env('SPOTIFY_CLIENT_SECRET'),
        "refresh_token"=>Auth::user()->refreshToken,
        "grant_type" =>'refresh_token'
        ];

        $ch = curl_init($url);//here i did use Curl way

        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        $err    = curl_error($ch);

        curl_close($ch);

        if ($err) {
            return Auth::user()->Token;
        }
        $result = json_decode($result, true);
        $check=User::where('id',Auth::user()->id)
        ->update([
           'Token'=>$result["access_token"]
         ]);
         if($check)
         {
            return response([
                "result"=>true,
                "status"=>Auth::user()->refreshToken,
                "message"=>$result["access_token"],

            ],200);
         }

    }
    public function logout(){
        Auth::logout();
    }

}
