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
        
});