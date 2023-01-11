<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Auth\User\{
    StoreRequest,
};
use App\Models\User;

class UserController extends Controller
{
    public function show (Request $request) {
        return $request->user();
    }

    public function store (StoreRequest $request) {

        $user = User::create(
                $request->only(['name', 'email', 'password'])
            );

        $user->refresh();
        
        $token = $user->createToken(
                $request->header('User-Agent', 'Unknown')
            )
            ->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }
}
