<?php

namespace Tests\Feature\Auth\SocialTokens;

use Tests\TestCase;

use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Mockery;

class CallbackTest extends TestCase
{
    use SocialHelper;

    protected function boot_mocker($type, $social_account_id) {

        $mock_user = Mockery::mock('Laravel\Socialite\Two\User');
        $mock_user
            ->shouldReceive('getId')
            ->andReturn($social_account_id);

        $mock_provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $mock_provider
            ->shouldReceive('user')
            ->andReturn($mock_user);
        $mock_provider
            ->shouldReceive('stateless')
            ->andReturn($mock_provider);

        Socialite::shouldReceive('driver')
            ->with($type)
            ->andReturn($mock_provider)
            ->once();
    }

    protected function new_user_login_via_social_oauth ($type) {

        $social_key = 'social->' . $type;
        $social_account_id = Str::random(10);

        $this->assertDatabaseMissing('users', [
            $social_key => $social_account_id,
        ]);

        $this->boot_mocker($type, $social_account_id);

        $response = $this->post(
            route('auth.social.tokens.callback', ['type' => $type])
        );

        $response->assertStatus(302);
        $response->assertRedirect('/profile');
        
        $token_from_request_cookie = $response->headers->getCookies()[0]->getValue();
        $auth_response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $token_from_request_cookie
            ])
            ->get(route('auth.user.show'));

        $auth_response->assertStatus(200);
    }

    public function test_new_user_login_via_social_oauth () {
        foreach ($this->getSocialProviders() as $type) {
            $this->new_user_login_via_social_oauth($type);
        }
    }

    protected function exist_user_login_via_social_oauth ($type) {

        $social_key = 'social->' . $type;
        $social_account_id = Str::random(10);

        $user = User::factory()->create([
            'social' => [
                $type => $social_account_id
            ]
        ]);

        $this->assertDatabaseHas('users', [
            $social_key => $social_account_id,
        ]);

        $this->boot_mocker($type, $social_account_id);

        $response = $this->post(
                route('auth.social.tokens.callback', ['type' => $type])
            );

        $response->assertStatus(302);
        $response->assertRedirect('/profile');


        $this->assertEquals(
            $user->social[$type],
            $social_account_id
        );
    }

    public function test_exist_user_login_via_social_oauth () {
        foreach ($this->getSocialProviders() as $type) {
            $this->exist_user_login_via_social_oauth($type);
        }
    }
}
