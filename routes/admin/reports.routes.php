<?php

use Illuminate\Support\Facades\Route;

/*
 * Users
 *
 * Prefix: /admin/reports
 */
Route::name('reports.')->group(function() {
    Route::resource('reports/teachers', 'Reports\TeachersReportsController', ['only' => ['create']]);
    Route::get('reports/teachers', 'Reports\TeachersReportsController@show')->name('teachers.show');
    Route::post('reports/teachers/{teacher}/receipt', 'Reports\TeachersReportsController@receipt')->name('teachers.receipt');

    Route::get('reports/students', 'Reports\StudentsReportsController@show')->name('students.show');
    Route::get('reports/students/detail', 'Reports\StudentsReportsController@detail')->name('students.detail');
    Route::get('reports/students/cancellation-detail', 'Reports\StudentsReportsController@cancellationDetail')->name('students.cancellation.detail');
    Route::resource('reports/students', 'Reports\StudentsReportsController', ['only' => ['create']]);

    Route::get('reports/receipts', 'Reports\ReceiptsController@create')->name('receipts.create');
    Route::any('reports/receipts/detail', 'Reports\ReceiptsController@show')->name('receipts.show');
});

