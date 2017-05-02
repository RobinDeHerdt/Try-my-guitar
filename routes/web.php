<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
], function () {
    Auth::routes();

    Route::get('/', 'HomeController@index')->name('home');
});

// @todo Add middleware for admin routes
Route::get('/admin/dashboard', 'AdminController@index')->name('dashboard');
Route::resource('articles', 'ArticleController');
// Route::get('/admin/article/index', 'ArticleController@index')->name('article.index');
