<?php

use Illuminate\Support\Facades\Route;

/*
 * Users
 *
 * Prefix: /admin/users
 */

Route::prefix('')->resource('users', 'UsersController', ['except' => ['show', 'create', 'store']]);
Route::patch('/users/{user}/reset', 'UsersController@reset')->name('users.reset');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('users.registerForm');
Route::post('/register', 'Auth\RegisterController@register')->name('users.register');
