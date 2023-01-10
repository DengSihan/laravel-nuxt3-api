<?php

Route::group([
    'middleware' => [
        'auth',
        'throttle:'.config('api.rate_limits.ordinary'),
    ],
], function (){

    Route::get(
            'user',
            'UserController@show'
        )
        ->name('user.show');
        
});