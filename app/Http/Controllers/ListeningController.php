<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Listening;
use Auth;
use DB;

class ListeningController extends Controller
{
    //
    function __construct() {
        $this->Spotify_url = env('SPOTIFY_URL');
    }
    public function StoreListening(){////Get Recently played From Spotify and save to Database table and then print object response


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
            'user_id'=>Auth::user()->provider_id,
            'artist_id'=>$response->object()->items[0]->track->artists[0]->id,
            'spotify_track_id'=>$response->object()->items[0]->track->id,
            'track_name'=>$response->object()->items[0]->track->name,
            'played_at'=>$response->object()->items[0]->played_at,




        ],200);



    }
    public function Get_recentPlayed(){
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

}
