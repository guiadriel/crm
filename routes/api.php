<?php

use App\Http\Controllers\Admin\Api\BookActivitiesController;
use App\Http\Controllers\Admin\SchedulesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/students', 'StudentsController@index')->name('api.students.index');
Route::post('/students', 'StudentsController@store')->name('api.students.store');

Route::post('/students/{student}/change-status', 'StudentsStatusController@update')->name('api.students.change-status');

Route::get('/books/{book}/activities', [BookActivitiesController::class, 'index'])->name('api.books.activities');

Route::prefix('')->resource('entries', 'EntriesController', ['except' => ['show', 'create', 'edit', 'store']])->names([
    'index' => 'api.entries.index',
]);
Route::prefix('')->resource('categories', 'CategoriesController', ['only' => ['index']])->names([
    'index' => 'api.categories.index',
]);

Route::get('calendar/events', [SchedulesController::class, 'calendar'])->name('api.schedules.calendar');
Route::get('calendar/events/{id}', [SchedulesController::class, 'destroy'])->name('api.schedules.destroy');

Route::get('/contracts', 'ContractsController@index')->name('api.contracts.index');


