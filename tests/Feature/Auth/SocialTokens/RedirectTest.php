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

            $this->assertStringStartsWith(
                $this->redirect[$type],
                $response->headers->get('Location')
            );
        }
    }
}
