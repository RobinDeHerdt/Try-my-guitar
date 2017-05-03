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

Route::group(['middleware' => ['role:1']], function () {
    Route::get('/admin/dashboard', 'AdminController@index')->name('dashboard');
    Route::get('/admin/articles/trashed', 'ArticleController@trashed')->name('articles.trashed');
    Route::post('/admin/articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::resource('/admin/articles', 'ArticleController');
});