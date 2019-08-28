<?php

use App\User;
use App\Blog;

Route::post('login', function () {
    $credentials = request()->only('email', 'password');

    if (auth()->once($credentials)) {
        $user = auth()->user();
        $user->api_token = \Str::random(80);
        $user->save();

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'api_token' => auth()->user()->api_token,
        ];
    }
});

Route::post('register', function () {

    request()->validate([
        'email' => 'required|email',
        'name' => 'required',
        'password' => 'required|min:6',
    ]);

    return User::create([
        'email' => request()->email,
        'name' => request()->name,
        'password' => bcrypt(request()->password),
    ]);
});

Route::get('blogs', function(){
  return Blog::all();
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('blog', BlogController::class);
});
