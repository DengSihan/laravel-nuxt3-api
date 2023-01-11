<?php

namespace Tests\Feature\Auth\SocialTokens;

use Tests\TestCase;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Mockery;

class RedirectTest extends TestCase
{
    protected $api = '/api/auth/social/{type}/tokens';

    protected function getSocialProviders ()
    {
        $socials = array_diff(array_keys(config('services')), ['mailgun', 'postmark', 'ses']);

        return $socials;
    }

    public function test_redirect_to_social_login () {

        foreach ($this->getSocialProviders() as $social) {

            $api = str_replace('{type}', $social, $this->api);

            $response = $this->get($api);

            $response->assertStatus(302);
        }

    }

    // public function test_guest_social_callback () {
            
    //     foreach ($this->getSocialProviders() as $social) {

    //         $api = str_replace('{type}', $social, $this->api) . '/callback';

    //         $mock_user = Mockery::mock('Laravel\Socialite\Two\User');

            

    //     }
    // }
}
