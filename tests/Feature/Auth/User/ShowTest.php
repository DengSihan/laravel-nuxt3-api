<?php

namespace Tests\Feature\Auth\User;

use Tests\TestCase;
use App\Models\User;

class ShowTest extends TestCase
{
    protected $api = '/api/auth/user';

    public function test_show_current_user () {

        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->get($this->api);

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
    }

    public function test_authed_only () {

        $response = $this->get($this->api);

        $response->assertStatus(401)
            ->assertJson([
                'message' => __('auth.unauthorized'),
            ]);
    }
}
