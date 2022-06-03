<?php

use Illuminate\Support\Facades\Route;

/*
 * Users
 *
 * Prefix: /admin/origins
 */
Route::prefix('')->resource('origins', 'OriginsController', ['except' => ['show']]);
