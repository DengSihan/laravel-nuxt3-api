<?php

namespace Tests\Feature\Auth\Tokens;

use Tests\TestCase;
use App\Models\User;

class StoreTest extends TestCase
{
    protected $api = '/api/auth/tokens';

    public function test_store_tokens_successful_response () {

        $user = User::factory()->create();

        $response = $this->withHeaders([
                'User-Agent' => $this->faker->userAgent,
            ])
            ->postJson($this->api, [
                'email' => $user->email,
                'password' => 'password',
            ]);

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
            ])
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at->jsonSerialize(),
                    'created_at' => $user->created_at->jsonSerialize(),
                    'updated_at' => $user->updated_at->jsonSerialize(),
                ],
            ]);
    }

    public function test_store_tokens_failed_response () {

        $user = User::factory()->create();

        $response = $this->withHeaders([
                'User-Agent' => $this->faker->userAgent,
            ])
            ->postJson($this->api, [
                'email' => $user->email,
                'password' => 'wrong-password',
            ]);

        $response->assertStatus(401)
            ->assertJsonStructure([
                'message',
                'errors' => [
                    'email',
                ]
            ])
            ->assertJson([
                'message' => __('auth.failed'),
                'errors' => [
                    'email' => [
                        __('auth.failed'),
                    ],
                ],
            ]);
    }
}
