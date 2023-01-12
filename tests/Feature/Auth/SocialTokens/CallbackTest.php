<?php

namespace Tests\Feature\Auth\SocialTokens;

use Tests\TestCase;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Mockery;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class CallbackTest extends TestCase
{
    use SocialHelper;

    public function test_github_social_oauth_callback () {

        $user = User::factory()->create();

        $provider = 'github';
        $token = Str::random(10);

        $mock = Mockery::mock('Laravel\Socialite\Two\User');
        $mock->shouldReceive('getId')->andReturn($user->id);

        $providerMock = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $providerMock->shouldReceive('user')->andReturn($mock);
        $providerMock->shouldReceive('stateless')->andReturn($providerMock);

        Socialite::shouldReceive('driver')->with($provider)->andReturn($providerMock)->once();

        $response = $this->post(
            route('auth.social.tokens.callback', ['type' => $provider])
        );

        $response->assertStatus(302);
        $response->assertRedirect('/profile');

        
    }
}
