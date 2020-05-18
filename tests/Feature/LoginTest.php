<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase {

    // $this->json is used to hit API end points
    // 
    // 
    // test to make sure the login route requires email & password data
    public function testRequiresEmailAndLogin() {
        $this->json('POST', 'api/login')
          ->assertStatus(422)
          ->assertJson([
            'email' => ['The email field is required'],
            'password' ['The password field is requried']
        ]);
    }

    // test to see if the correct status & json object is returned when a 
    // user attempts to login
    public function testUserLoginsSuccessfully() {

        // create a user
        $user = factory(User::class)->create([
          'email' => 'testlogin@user.com',
          'password' => bcrypt('admin')
        ]);

        // prepare the login payload
        $payload = ['email' => 'testlogin@user.com', 'password' => bcrypt('admin')];

        // user in and check response
        $this->json('POST', 'api/login', $payload)
          ->assertStatus(200) // check the returned status
          ->assertJsonStructure([// check that the object returned when logging in has all the correct fields
            'data' => [
              'id',
              'name',
              'email',
              'created_at',
              'updated_at',
              'api_token'
            ]
        ]);
    }

}
