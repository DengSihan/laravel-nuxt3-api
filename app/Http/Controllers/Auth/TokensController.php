<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Tokens\{
    StoreRequest,
};
use App\Models\{
    User,
};
use Illuminate\Support\Facades\Hash;


class TokensController extends Controller
{
    public function store (StoreRequest $request) {

        $user = User::where('email', $request->email)->first();

        if (
            $user
            && Hash::check($request->password, $user->password)
        ) {
            $token = $user
                ->createToken(
                    $request->header('User-Agent', 'Unknown')
                )
                ->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 201);
        }
        else {
            return response()->json([
                'message' => __('auth.failed'),
                'errors' => [
                    'email' => [
                        __('auth.failed'),
                    ],
                ],
            ], 401);
        }
    }

    public function destroyCurrent (Request $request) {

        $request->user()->currentAccessToken()->delete();

        return response()->noContent();
    }

}
