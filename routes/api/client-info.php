<?php

Route::group([
    'middleware' => [
        'throttle:' . config('api.rate_limits.ordinary'),
    ]
], function() {

    Route::get(
            'client-info',
            'ClientInfoController@show'
        )
        ->name('client-info.show');
});