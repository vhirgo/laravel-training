<?php

namespace App\Http\Controllers;

use App\User;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $this->validate(request(), [
            'email' => 'required|email',
            'name' => 'required',
            'password' => 'required|min:6',
        ]);

        return User::create([
            'email' => request()->email,
            'name' => request()->name,
            'password' => bcrypt(request()->password),
        ]);
    }
}
