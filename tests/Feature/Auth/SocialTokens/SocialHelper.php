<?php

namespace Tests\Feature\Auth\SocialTokens;

trait SocialHelper {
    protected function getSocialProviders () {
        return array_diff(array_keys(config('services')), ['mailgun', 'postmark', 'ses']);
    }
}