<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ListeningController;
use App\Http\Controllers\AuthController;
use Auth;


class UserController extends Controller
{
    //

    function __construct() {

        $this->unauthenticatedMessage ="unauthenticated Please Login";
        $this->unauthenticatedStatus =403;
        $this->unauthenticatedResult=false;
      }
    /* AuthController Action */
    public function UserLogin(){
        return (new AuthController)->login();
    }
    public function UserCallback(){
        return (new AuthController)->callback();
    }

    public function UsersDetails(){
        if(Auth::check())
        {
            return (new AuthController)->UsersDetails();
        }
        else{
            return response([
                "result"=>$this->unauthenticatedResult,
                "status"=>$this->unauthenticatedStatus,
                "message"=>$this->unauthenticatedMessage,

            ],201);
        }
    }

    /* Listening Controller Action  */
    public function UserStore_listening(){ //Get Recently played From Spotify and save to Database table
        if(Auth::check())
        {
            return (new ListeningController)->StoreListening();
        }
        else{
            return response([
                "result"=>$this->unauthenticatedResult,
                "status"=>$this->unauthenticatedStatus,
                "message"=>$this->unauthenticatedMessage,

            ],201);
        }
    }

    public function UserListening(){ //Get all recently played track from Database  tables
        if(Auth::check())
        {
            return (new ListeningController)->Get_recentPlayed();
        }
        else{
            return response([
                "result"=>$this->unauthenticatedResult,
                "status"=>$this->unauthenticatedStatus,
                "message"=>$this->unauthenticatedMessage,

            ],201);
        }
    }
}
