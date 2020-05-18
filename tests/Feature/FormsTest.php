<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Form;

class FormsTest extends TestCase {

    public function testFormStore() {
        /*
          |--------------------------------------------------------------------------
          | Expected Functionality
          |--------------------------------------------------------------------------
         *  1. return form object
         *  2. return 201 status
         */

        // create a user
        $user = factory(User::class)->create([
          'email' => 'testlogin@user.com',
          'password' => bcrypt('admin')
        ]);
        $token = $user->generateToken();

        $headers = ["Authorization" => "Bearer $token"];

        $payload = ['form_name' => 'test_form'];

        $this->json("POST", 'api/forms', $payload, $headers)
          ->assertStatus(201)
          ->assertJson([
            'id' => 1,
            'form_name' => 'test_form'
        ]);
    }

    public function testFormUpdate() {
        $user = factory(User::class)->create([
          'email' => 'testlogin@user.com',
          'password' => bcrypt('admin')
        ]);
        $token = $user->generateToken();

        $headers = ["Authorization" => "Bearer $token"];

        $form = Form::create([
            'form_name' => 'test_form'
        ]);

        $payload = ['form_name' => 'UPDATED'];

        $this->json("PUT", 'api/forms/' . $form->id, $payload, $headers)
          ->assertStatus(200)
          ->assertJson([
            'form_name' => 'UPDATED'
        ]);
    }

    public function testFormDelete() {
        $user = factory(User::class)->create([
          'email' => 'testlogin@user.com',
          'password' => bcrypt('admin')
        ]);
        $token = $user->generateToken();

        $headers = ["Authorization" => "Bearer $token"];

        $form = Form::create([
            'form_name' => 'test_form'
        ]);

        $this->json("DELETE", 'api/forms/' . $form->id, [], $headers)
          ->assertStatus(204)
          ->assertJson(NULL);
    }

    public function testFormList() {
        $user = factory(User::class)->create([
          'email' => 'testlogin@user.com',
          'password' => bcrypt('admin')
        ]);
        $token = $user->generateToken();

        $headers = ["Authorization" => "Bearer $token"];

        // create two forms
        factory(Form::class)->create([
          'form_name' => 'form_1'
        ]);
        factory(Form::class)->create([
          'form_name' => 'form_2'
        ]);

        $this->json("GET", 'api/forms', [], $headers)
          ->assertStatus(200)
          ->assertJson([
            ['form_name' => 'form_1'],
            ['form_name' => 'form_2']
          ])
          ->assertJsonStructure([
            '*' => ['id', 'form_name', 'created_at', 'updated_at']
        ]);
    }

}
