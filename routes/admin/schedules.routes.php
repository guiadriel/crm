<?php

use Illuminate\Support\Facades\Route;

Route::get('schedules/print', 'SchedulesController@print')->name('schedules.print');

Route::prefix('')->resource('schedules', 'SchedulesController', ['except' => []]);
Route::prefix('')->resource('periodic-schedules', 'PeriodSchedulesController', ['only' => ['store']]);

