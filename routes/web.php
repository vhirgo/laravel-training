<?php

Route::get('/', function() {
    return "Silahkan cek " . url()->current() . '/api';
});
