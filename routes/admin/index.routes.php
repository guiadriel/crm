<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('_home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/account', 'AccountController@index')->name('account');

Route::group([], __DIR__.'/users.routes.php');
Route::group([], __DIR__.'/origins.routes.php');
Route::group([], __DIR__.'/class.routes.php');
Route::group([], __DIR__.'/cashflow.routes.php');
Route::group([], __DIR__.'/schedules.routes.php');
Route::group([], __DIR__.'/settings.routes.php');
Route::group([], __DIR__.'/reports.routes.php');


Route::prefix('')->resource('roles', 'RolesController', ['except' => ['show']]);

Route::prefix('')->resource('students', 'StudentsController');
Route::prefix('')->resource('prospects', 'ProspectsController');
Route::prefix('')->resource('remarketing', 'RemarketingController');
Route::prefix('')->resource('student-logs', 'StudentLogController');
Route::prefix('')->resource('teachers', 'TeachersController', ['except' => ['show']]);
Route::prefix('')->resource('teachers-files', 'TeacherFilesController', ['only' => ['show', 'destroy']]);
Route::prefix('')->resource('contracts', 'ContractsController', ['except' => ['show']]);
Route::prefix('')->resource('contracts-models', 'ContractsModelController', ['except' => ['show']]);
Route::prefix('')->resource('contracts-payment', 'ContractsPaymentController', ['except' => ['show']]);

Route::get('/contracts/{contract}/generate', 'ContractsPDFController@generate')->name('contracts.generate');

Route::post('/contracts/{contract}/generate', 'ContractsPDFController@renderPDF')->name('contracts.renderpdf');
Route::patch('/contracts/{contract}/execute', 'ContractsExecutionController@execute')->name('contracts.execute');
Route::post('/contracts-payment/{contract}/generate', 'ContractsPaymentController@renderPDF')->name('contracts-payment.renderpdf');

Route::prefix('')->resource('paragraph', 'ParagraphController');
Route::prefix('')->resource('bills', 'BillsController');
Route::prefix('')->resource('receipts', 'ReceiptsController');
Route::prefix('')->resource('frequency', FrequencyController::class);
Route::prefix('')->resource('categories', 'CategoriesController', ['except' => ['show']]);
Route::prefix('')->resource('sub-categories', 'SubCategoriesController', ['except' => ['show','index']]);
Route::prefix('')->resource('books', 'BooksController', ['except' => ['show']]);
Route::prefix('')->resource('entries', 'EntriesController', ['only' => ['index', 'store']]);

Route::prefix('')->resource('payment-methods', 'PaymentsMethodsController');

Route::resource('site-config', SiteConfigController::class)
    ->only(['edit', 'update'])
    ->names([
        'edit' => 'admin.siteconfig.edit',
        'update' => 'admin.siteconfig.update',
    ])
;

Route::get('calendar/events', 'SchedulesController@calendar')->name('schedules.calendar');

