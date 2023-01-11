<?php

namespace Tests\Feature\Auth\User;

use Tests\TestCase;
use Illuminate\Support\Str;

class StoreTest extends TestCase
{
    protected $api = '/api/auth/user';
    
    public function test_store_user () {

        $password = Str::random(10);

        $profile = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $response = $this->post($this->api, $profile);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
