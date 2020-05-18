<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Auth\User;

class LogoutTest extends TestCase {

    /**
     * --------------------------------
     * Expected functionality
     * --------------------------------
     *  1. set users api_token to null
     *  2. return status of 200
     *  3. return data => 'User logged out.'
     */
    public function testUserIsLoggedOutProperly() {
        $user = factory(User::create([
            'name' => 'admin',
            'password' => 'admin'
        ]));

        $token = $user->generateToken();

        $headers = ['Authorization' => "Bearer $token"];

        // test the user is logged in properly & has access to the forms
        $this->json("GET", 'api/forms', [], $headers)
          ->assertStatus(200);

        // log the user out and check the status returned
        $this->json("POST", 'api/logout', [], $headers)
          ->assertStatus(200);

        $user = User::find($user->id);

        // check if api_token field in the user object is set to null
        $this->assertEquals(null, $user->api_token);
    }

    public function testUserWithNullToken() {
        // simulate login
        $user = factory(User::create([
            'name' => 'admin',
            'password' => 'admin'
        ]));

        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        // simulate logout
        $user->api_token = null;
        $user->save();

        // make a get request to forms
        $this->json("GET", 'api/forms', [], $headers)->assertStatus(401);
    }

}
