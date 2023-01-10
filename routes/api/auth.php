<?php

Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth',
    'as' => 'auth.',
], function() {

    include 'auth/tokens.php';

});