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
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('login/twitter', 'Auth\LoginController@redirectToTwitter');
Route::get('login/twitter/callback', 'Auth\LoginController@handleTwitterCallback');
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect' ]
], function () {
    // Authentication related routes.
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    // Verification related routes.
    Route::get('/verify/{id}/{token}', 'Auth\VerifyController@verify')->name('verify');
    Route::get('/verify/resend', 'Auth\VerifyController@resend')->name('verify.resend');

    // Main navigation routes.
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('about', 'AboutController@index')->name('about');
    Route::get('experience', 'ExperienceController@index')->name('experience');
    Route::get('explore', 'ExploreController@explore')->name('explore');
    Route::get('disclaimer', 'HomeController@disclaimer')->name('disclaimer');
    Route::get('search', 'SearchController@result')->name('search');
    Route::get('search/autocomplete', 'SearchController@autoComplete')->name('search.autocomplete');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('contributions', 'ProfileController@contributions')->name('contributions');

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
    Route::post('guitar/{guitar}/remove', 'GuitarController@destroy')->name('guitar.destroy');
    Route::post('guitar/image/{guitarImage}/remove', 'GuitarController@destroyImage')->name('guitar.image.destroy');
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
Route::post('experience/{experience}/vote', 'ExperienceController@vote')->name('experience.vote');

// Cookie routes.
Route::post('cookie', 'CookieController@store');

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

    // Admin user related routes.
    Route::get('admin/users', 'UserController@index')->name('admin.users.index');

    // Admin guitar related routes.
    Route::get('admin/guitars', 'GuitarController@index')->name('admin.guitars.index');
    Route::post('admin/guitars/{guitar}/destroy', 'GuitarController@adminDestroy')->name('admin.guitars.destroy');

    // Admin guitarimage related routes.
    Route::get('admin/guitarimages', 'GuitarimageController@index')->name('admin.guitarimages.index');
    Route::post('admin/guitarimages/{guitarimage}/destroy', 'GuitarimageController@destroy')->name('admin.guitarimages.destroy');

    // Admin call to action related routes.
    Route::get('admin/cta-items', 'CtaItemController@index')->name('admin.cta.index');
    Route::get('admin/cta-items/create', 'CtaItemController@create')->name('admin.cta.create');
    Route::get('admin/cta-items/{cta_item}', 'CtaItemController@show')->name('admin.cta.show');
    Route::get('admin/cta-items/{cta_item}/edit', 'CtaItemController@edit')->name('admin.cta.edit');
    Route::post('admin/cta-items/store', 'CtaItemController@store')->name('admin.cta.store');
    Route::post('admin/cta-items/{cta_item}/update-status', 'CtaItemController@updateStatus')->name('admin.cta.update-status');
    Route::post('admin/cta-items/{cta_item}/update', 'CtaItemController@update')->name('admin.cta.update');
    Route::post('admin/cta-items/{cta_item}/destroy', 'CtaItemController@destroy')->name('admin.cta.destroy');
});
