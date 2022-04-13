<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'LoginController@show')->name('show');
Route::post('/login', 'LoginController@login')->name('login');