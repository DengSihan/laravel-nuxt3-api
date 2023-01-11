<?php

namespace Tests\Feature\Auth\Tokens;

use Tests\TestCase;
use App\Models\User;

class DestroyCurrentTest extends TestCase
{
    protected $api = '/api/auth/token';

    public function test_destroy_current_token () {

        $user = User::factory()->create();

        $token = $user
            ->createToken(
                $this->faker->userAgent
            )
            ->plainTextToken;

        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token,
            ])
            ->deleteJson($this->api);

        $response->assertNoContent();
    }
}
