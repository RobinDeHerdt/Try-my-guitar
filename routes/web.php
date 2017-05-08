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

    // Dashboard
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Profile
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/{id}', 'ProfileController@show')->name('profile.show');
    Route::post('profile/update', 'ProfileController@update')->name('profile.update');

    // Conversation overview
    Route::get('conversations', 'ConversationController@index')->name('conversation.index');
    Route::get('conversations/{id}', 'ConversationController@show')->name('conversation.show');

    Route::get('conversations/{id}/messages', 'ConversationController@messages');
    Route::post('conversations/{id}/messages', 'ConversationController@store');

    Route::post('conversations/{id}/messages/seen', 'ConversationController@seen');
});

// Administrator only.
Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('admin/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('admin/articles/trashed', 'ArticleController@trashed')->name('articles.trashed');
    Route::post('admin/articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::resource('admin/articles', 'ArticleController');
});