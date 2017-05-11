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

    Route::get('profile/{user}/invite', 'ProfileController@invite')->name('profile.invite');

    // Conversation related routes.
    Route::get('conversations', 'ConversationController@index')->name('conversation.index');
    Route::get('conversations/{channel}', 'ConversationController@show')->name('conversation.show');
    Route::post('conversations/edit', 'ConversationController@update')->name('conversation.update');
    Route::post('conversations/leave', 'ConversationController@leave')->name('conversation.leave');

    Route::post('invite', 'ConversationController@sendInvite')->name('invite');
    Route::post('invite/response', 'ConversationController@inviteResponse')->name('invite.response');

    // Conversation API related routes.
    Route::get('conversations/{channel}/messages', 'ConversationController@messages');
    Route::post('conversations/{channel}/messages', 'ConversationController@store');
    Route::post('conversations/{channel}/messages/seen', 'ConversationController@seen');
});

// Administrator only.
Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('admin/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('admin/articles/trashed', 'ArticleController@trashed')->name('articles.trashed');
    Route::post('admin/articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::resource('admin/articles', 'ArticleController');
});