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
    // Authentication related routes.
    Auth::routes();
    Route::get('/verify/{id}/{token}', 'Auth\VerifyController@verify')->name('verify');
    Route::get('/verify/resend', 'Auth\VerifyController@resend')->name('verify.resend');

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('search', 'SearchController@search')->name('search');

    // Dashboard related routes.
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Profile related routes.
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/{id}', 'ProfileController@show')->name('profile.show');
    Route::post('profile/update', 'ProfileController@update')->name('profile.update');
    Route::post('profile/appearance/update', 'ProfileController@updateAppearance')->name('profile.appearance.update');

    Route::get('profile/{user}/invite', 'ProfileController@invite')->name('profile.invite');

    // Chat related routes.
    Route::get('chat/channels', 'ChatController@index')->name('chat.index');
    Route::get('chat/channel/{channel}', 'ChatController@show')->name('chat.show');
    Route::post('chat/channel/edit', 'ChatController@update')->name('chat.update');
    Route::post('chat/channel/{channel}/leave', 'ChatController@leave')->name('chat.leave');
    Route::post('chat/channel/invite', 'ChatController@sendInvite')->name('invite');
    Route::post('chat/channel/invite/response', 'ChatController@inviteResponse')->name('invite.response');
});

Route::get('api/chat/channel/{channel}', 'ChatController@channel');
Route::get('api/chat/channel/{channel}/messages', 'ChatController@messages');
Route::post('api/chat/channel/{channel}/messages/send', 'ChatController@store');
Route::post('api/chat/channel/{channel}/messages/seen', 'ChatController@seen');

// Administrator only.
Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('admin/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('admin/articles/trashed', 'ArticleController@trashed')->name('articles.trashed');
    Route::post('admin/articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::resource('admin/articles', 'ArticleController');
});