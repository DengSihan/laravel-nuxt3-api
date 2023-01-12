<?php

namespace Tests\Feature\CLientInfo;

use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_show_client_info () {

        $ip = $this->faker->ipv4;
        $userAgent = $this->faker->userAgent;

        $response = $this
            ->withHeaders([
                'User-Agent' => $userAgent,
            ])
            ->getJson(
                route('client-info.show'),
                [
                    'REMOTE_ADDR' => $ip,
                ]
            );

        $response
            ->assertStatus(200)
            ->assertJson([
                'ip' => $ip,
                'user_agent' => $userAgent,
            ]);
    }
}
