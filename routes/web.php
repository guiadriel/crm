<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| There are separated at admin folder
| Admin Routes: /admin/index.routes.php
|
*/
Route::get('/', function () {
    return redirect('/admin');
});
// Route::get('/about-us', 'Site\SiteController@aboutus')->name('site.aboutus');
// Route::get('/contact', 'Site\SiteController@contact')->name('site.contact');
// Route::get('/courses', 'Site\SiteController@courses')->name('site.courses');
// Route::get('/ie', 'Site\SiteController@ie')->name('site.ie');
// Route::get('/work-with-us', 'Site\SiteController@workwithus')->name('site.workwithus');

Route::get('/admin/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
Route::post('/admin/login', 'Admin\Auth\LoginController@login');
Route::post('/admin/logout', 'Admin\Auth\LoginController@logout')->name('logout');
