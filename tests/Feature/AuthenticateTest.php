<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Auth;

class AuthenticateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_if_App_is_Working()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_if_Login_Post_Data_and_redirect_to(){
        $response = $this->call('GET', 'auth/login');

        $response->assertStatus(302);
    }
    public function test_if_CallBack_will_give_Errors_if_there_is_no_Token(){
        $response = $this->call('GET', 'auth/callback');

        //dd($response);
     $response->assertStatus(500);
    }
    public function test_if_user_is_authenticated(){

           $response=$this->get('users');

          $response->assertStatus(201);
          $this->assertEquals("unauthenticated Please Login",$response['message']);

    }
    public function test_if_UserStore_listening_is_authenticated(){

        $response=$this->get('userStore_listening');

        $this->assertEquals("unauthenticated Please Login",$response['message']);
        $response->assertStatus(201);
    }
    public function test_if_User_listening_is_authenticated(){

        $response=$this->get('user_listening');

        $this->assertEquals("unauthenticated Please Login",$response['message']);
        $response->assertStatus(201);
    }


}
