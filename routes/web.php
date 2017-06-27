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

    // Verification related routes.
    Route::get('/verify/{id}/{token}', 'Auth\VerifyController@verify')->name('verify');
    Route::get('/verify/resend', 'Auth\VerifyController@resend')->name('verify.resend');

    // Main navigation routes.
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('about', 'AboutController@index')->name('about');
    Route::get('explore', 'ExploreController@explore')->name('explore');
    Route::get('disclaimer', 'HomeController@disclaimer')->name('disclaimer');
    Route::get('search', 'SearchController@result')->name('search');
    Route::get('search/autocomplete', 'SearchController@autoComplete')->name('search.autocomplete');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    // Article related routes.
    Route::get('article/{article}/{title}', 'ArticleController@showPublic')->name('article.public.show');
    Route::get('articles', 'ArticleController@indexPublic')->name('article.public.index');
    Route::post('comment/store', 'CommentController@store')->name('comment.store');
    Route::post('comment/{comment}/destroy', 'CommentController@destroy')->name('comment.destroy');

    // Contact message related routes.
    Route::post('contact', 'ContactController@store')->name('contact');

    // Profile related routes.
    Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
    Route::get('profile/{user}', 'ProfileController@show')->name('profile.show');
    Route::get('profile/{user}/report', 'ReportController@create')->name('report.create');
    Route::get('profile/{user}/invite', 'ProfileController@invite')->name('profile.invite');
    Route::get('profile/{user}/experiences', 'ProfileController@experiences')->name('profile.experiences');
    Route::get('profile/autocomplete', 'ProfileController@autoComplete')->name('profile.autocomplete');
    Route::post('profile/{user}/report', 'ReportController@store')->name('report.store');
    Route::post('profile/update', 'ProfileController@update')->name('profile.update');
    Route::post('profile/appearance/update', 'ProfileController@updateAppearance')->name('profile.appearance.update');

    // Guitar related routes.
    Route::get('guitar/create', 'GuitarController@create')->name('guitar.create');
    Route::get('guitar/{guitar}', 'GuitarController@show')->name('guitar.show');
    Route::get('guitar/{guitar}/experiences', 'GuitarController@experiences')->name('guitar.show.experiences');
    Route::get('guitar/{guitar}/experience/create', 'ExperienceController@create')->name('experience.create');
    Route::get('guitar/{guitar}/image/create', 'GuitarController@createImage')->name('guitar.image.create');
    Route::get('brand/{brand}', 'BrandController@show')->name('brand.show');
    Route::get('type/{type}', 'TypeController@show')->name('type.show');
    Route::post('guitar/{guitar}/image/store', 'GuitarController@storeImage')->name('guitar.image.store');
    Route::post('guitar/store', 'GuitarController@store')->name('guitar.store');

    // Collection related routes.
    Route::get('collection/autocomplete', 'CollectionController@autoComplete')->name('collection.autocomplete');
    Route::get('profile/{user}/collection', 'CollectionController@show')->name('collection.show');
    Route::get('collection/add', 'CollectionController@create')->name('collection.create');
    Route::post('collection/store', 'CollectionController@store')->name('collection.store');
    Route::post('collection/{guitar}/remove', 'CollectionController@destroy')->name('collection.destroy');

    Route::post('collection/{guitar}/experience/add', 'ExperienceController@store')->name('experience.store');
    Route::post('experience/{experience}/destroy', 'ExperienceController@destroy')->name('experience.destroy');
    Route::post('experience/{experience}/update', 'ExperienceController@update')->name('experience.update');
    Route::post('experience/{experience}/vote', 'ExperienceController@vote')->name('experience.vote');

    // Chat related routes.
    Route::get('chat/channels', 'ChatController@index')->name('chat.index');
    Route::get('chat/channel/{channel}', 'ChatController@show')->name('chat.show');
    Route::post('chat/channel/{channel}/leave', 'ChatController@leave')->name('chat.leave');
    Route::post('chat/channel/invite', 'ChatController@sendInvite')->name('invite');
    Route::post('chat/channel/invite/response', 'ChatController@inviteResponse')->name('invite.response');
});

// Async chat routes.
Route::get('user', 'ChatController@user');
Route::get('channels', 'ChatController@channels');
Route::get('channel/{channel}', 'ChatController@channel');
Route::get('channel/{channel}/messages', 'ChatController@messages');
Route::post('channel/{channel}/messages/send', 'ChatController@store');
Route::post('channel/{channel}/messages/seen', 'ChatController@seen');
Route::post('chat/channel/{channel}/update', 'ChatController@update')->name('chat.update');

// Async routes.
Route::get('explore/map', 'ExploreController@getLocations');
Route::get('guitar/{guitar}/map', 'GuitarController@getLocations');

// Admin related routes.
Route::group(['middleware' => ['role:administrator']], function () {
    Route::get('admin/dashboard', 'AdminController@index')->name('admin.dashboard');

    // Admin article related routes.
    Route::get('admin/articles/trashed', 'ArticleController@trashed')->name('articles.trashed');
    Route::post('admin/articles/{id}/restore', 'ArticleController@restore')->name('articles.restore');
    Route::resource('admin/articles', 'ArticleController');

    // Admin contact message related routes.
    Route::get('admin/messages', 'ContactController@index')->name('admin.messages.index');
    Route::get('admin/messages/{contact_message}', 'ContactController@show')->name('admin.messages.show');

    // Admin report related routes.
    Route::get('admin/reports', 'ReportController@index')->name('admin.reports.index');
    Route::get('admin/reports/{report}', 'ReportController@show')->name('admin.reports.show');
    Route::post('admin/reports/{report}', 'ReportController@reviewed')->name('admin.reports.reviewed');
});
