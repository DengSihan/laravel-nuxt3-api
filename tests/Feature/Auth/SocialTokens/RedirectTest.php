<?php

namespace Tests\Feature\Auth\SocialTokens;

use Tests\TestCase;

class RedirectTest extends TestCase
{
    use SocialHelper;

    protected $redirect = [
        'github' => 'https://github.com/login/oauth/authorize',
    ];

    public function test_social_redirect () {
        foreach ($this->getSocialProviders() as $type) {
            
            $response = $this->post(
                route('auth.social.tokens.redirect', ['type' => $type])
            );

            $response->assertStatus(302);

            $redirect_location = $response->headers->get('Location');
            $this->assertStringStartsWith($this->redirect[$type], $redirect_location);
        }
    }
}
