<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __invoke()
    {
        $credentials = request()->only('email', 'password');

        if (auth()->once($credentials)) {
            $user = auth()->user();
            $user->api_token = Str::random(80);
            $user->save();

            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'api_token' => auth()->user()->api_token,
            ];
        }

        return [
            'message' => 'Invalid credentials.'
        ];
    }
}
