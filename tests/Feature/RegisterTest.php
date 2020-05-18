<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase {

    /**
     * --------------------------------
     * Expected functionality
     * --------------------------------
     *  1. New user is created in the database
     *  2. Data object containing the user info is returned
     *  3. Status 201 is returned
     *  4. Registration requires certain fields password email & name
     *  5. Password & password_confirmation must match
     */
    public function testRegistersSuccessfully() {
        $payload = [
          'name' => 'John',
          'email' => 'john@toptal.com',
          'password' => 'toptal12312',
          'password_confirmation' => 'toptal12312',
        ];

        $this->json('post', '/api/register', $payload)
          ->assertStatus(201)
          ->assertJsonStructure([
            'data' => [
              'id',
              'name',
              'email',
              'created_at',
              'updated_at',
              'api_token',
            ],
        ]);
        ;
    }

    public function testRequiresPasswordEmailAndName() {
        $this->json("POST", 'api/register')
          ->assertStatus(422)
          ->assertJson([
            'errors' => [
              'name' => ['The name field is required.'],
              'email' => ['The email field is required.'],
              'password' => ['The password field is required.']
            ]
        ]);
    }

    public function testRequiresPasswordConfirmation() {
        $payload = [
          'name' => 'John',
          'email' => 'john@toptal.com',
          'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
          ->assertStatus(422)
          ->assertJson([
            'errors' => [
              'password' => ['The password confirmation does not match.']
            ]
        ]);
    }

}
