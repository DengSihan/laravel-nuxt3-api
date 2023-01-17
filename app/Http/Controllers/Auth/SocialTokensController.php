<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialTokensController extends Controller
{

    protected function getProfilePageUrl () {
        return config('app.url') . '/profile';
    }

    public function redirect (String $type) {
        return Socialite::driver($type)->stateless()->redirect();
    }

    public function callback (String $type, Request $request) {

        $credentials = Socialite::driver($type)->stateless()->user();
        
        $user = User::where('social->' . $type, '=', $credentials->id)->first();

        // if the user is not exist, create a new one
        if (!$user) {
            $profile = [
                'name' => 'user-' . Str::random(8),
                'social' => [
                    $type => $credentials->id
                ]
            ];
            $user = User::create($profile);
        }

        $token = $user->createToken(Str::random(8))->plainTextToken;

        // https://github.com/laravel/framework/blob/f02eca97368f4973079f279955cb3ed2551a985b/src/Illuminate/Foundation/helpers.php#L308
        $cookie = cookie(
            'token',
            $token,
            config('auth.validity_period'),
            null,
            null,
            null,
            false,
            true,
        );

        return redirect($this->getProfilePageUrl(), 302)
            ->withCookie($cookie);
        
    }
}
