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

Route::get('profile', 'ProfileController@index')->name('profile');
Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');

Route::get('conversations', 'MessageController@index')->name('conversations');

Route::get('channel/{id}', 'ChannelController@show')->name('channels.show');
Route::get('channel/{id}/messages', 'ChannelController@messages');
Route::post('channel/{id}/messages', 'MessageController@store');

// Administrator only.
Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('admin/dashboard', 'AdminController@index')->name('dashboard');
    Route::get('admin/articles/trashed', 'ArticleController@trashed')->name('articles.trashed');
    Route::post('admin/articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::resource('admin/articles', 'ArticleController');
});