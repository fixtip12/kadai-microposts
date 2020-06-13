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

Route::get('/', 'MicropostsController@index');

Route::namespace('Auth')->group(function () {
    // ユーザ登録
    Route::get('signup', 'RegisterController@showRegistrationForm')->name('signup.get');
    Route::post('signup', 'RegisterController@register')->name('signup.post');
    // ログイン認証
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login')->name('login.post');
    Route::get('logout', 'LoginController@logout')->name('logout.get');
});

// ユーザ機能
Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', 'UsersController', ['only' => ['index', 'show']]);
    
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });

    // 追加
    Route::group(['prefix' => 'microposts/{id}'], function () {
        Route::post('favorite', 'FavoritesController@store')->name('users.favorites');
        Route::delete('unfavorite', 'FavoritesController@destroy')->name('users.unfavorite');
        Route::get('is_favorite','UsersController@favorites')->name('users.is_favorite');
    });
    
    Route::resource('microposts', 'MicropostsController', ['only' => ['store', 'destroy']]);
});
