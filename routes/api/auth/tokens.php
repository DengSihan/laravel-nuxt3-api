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