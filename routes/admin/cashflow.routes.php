<?php

use Illuminate\Support\Facades\Route;

Route::prefix('')->resource('cashflow', 'CashFlowController', ['only' => ['index']]);

Route::get('export/', 'CashFlowController@download')->name('cashflow.export');
