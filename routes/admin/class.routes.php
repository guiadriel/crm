<?php

use Illuminate\Support\Facades\Route;

Route::prefix('')->resource('class', 'GroupClassController', ['except' => ['show']]);
Route::get('class/{class}/detach', 'GroupClassController@detachStudent')->name('class.detach');
