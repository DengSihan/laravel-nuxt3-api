<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientInfoController extends Controller
{
    public function show (Request $request) {

        $client_info = [
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ];

        return response()->json($client_info);
    }
}
