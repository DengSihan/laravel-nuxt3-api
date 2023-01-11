<?php

Route::group([
    'middleware' => [
        'auth',
        'throttle:'.config('api.rate_limits.ordinary'),
    ],
], function () {

    Route::get(
            'user',
            'UserController@show'
        )
        ->name('user.show');

});

Route::group([
    'middleware' => [
        'guest',
        'throttle:'.config('api.rate_limits.extreme'),
    ],
], function () {

    Route::post(
            'user',
            'UserController@store'
        )
        ->name('user.store');
});