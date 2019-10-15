<?php

// Authentication
Route::get('/register', 'RegisterController');
Route::get('/login', 'LoginController');


// Product
Route::get('/product_images/{image}', 'ProductImageController');
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('/products/{product}', [App\Http\Controllers\ProductController::class, 'show']);
Route::post('/products', [App\Http\Controllers\ProductController::class, 'store']);
Route::put('/products/{product}', [App\Http\Controllers\ProductController::class, 'update']);
Route::delete('/products/{product}', [App\Http\Controllers\ProductController::class, 'destroy']);

// Tasks
Route::get('/tasks', 'TaskController@index');
Route::get('/tasks/{task}', 'TaskController@show');
Route::post('/tasks', 'TaskController@store')->middleware('auth:api');
Route::put('/tasks/{task}', 'TaskController@update')->middleware('auth:api');
Route::delete('/tasks/{task}', 'TaskController@destroy')->middleware('auth:api');

// Blog
Route::get('/blog', 'BlogController@index');
Route::get('/blog/{blog}', 'BlogController@show');
Route::post('/blog', 'BlogController@store')->middleware('auth:api');
Route::put('/blog/{blog}', 'BlogController@update')->middleware('auth:api');
Route::delete('/blog/{blog}', 'BlogController@destroy')->middleware('auth:api');
