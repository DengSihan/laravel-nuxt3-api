<?php

Route::group([
    'middleware' => [
        'guest',
        'throttle:'.config('api.rate_limits.extreme'),
    ],
], function (){

    Route::post(
            'tokens',
            'TokensController@store'
        )
        ->name('tokens.store');

    $socials = implode('|', array_diff(array_keys(config('services')), ['mailgun', 'postmark', 'ses']));

    // social login
    Route::post('social/{type}/tokens', 'SocialTokensController@redirect')
        ->where('type', $socials)
        ->name('social.tokens.redirect');
    
    // social login callback
    Route::any('social/{type}/tokens/callback', 'SocialTokensController@callback')
        ->where('type', $socials)
        ->name('social.tokens.callback');
        
});

Route::group([
    'middleware' => [
        'auth',
        'throttle:'.config('api.rate_limits.ordinary'),
    ],
], function () {

    Route::delete(
            'token',
            'TokensController@destroyCurrent'
        )
        ->name('tokens.destroyCurrent');
    
});