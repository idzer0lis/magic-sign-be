<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api'], function () {

    Route::post('users/login', 'AuthController@login');
    Route::post('users', 'AuthController@register');

    Route::get('user', 'UserController@index');
    Route::match(['put', 'patch'], 'user', 'UserController@update');

    Route::get('profiles/{user}', 'ProfileController@show');
    Route::post('profiles/{user}/follow', 'ProfileController@follow');
    Route::delete('profiles/{user}/follow', 'ProfileController@unFollow');

    Route::get('articles/feed', 'FeedController@index');
    Route::post('articles/{article}/favorite', 'FavoriteController@add');
    Route::delete('articles/{article}/favorite', 'FavoriteController@remove');

    Route::resource('articles', 'ArticleController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    Route::resource('articles/{article}/comments', 'CommentController', [
        'only' => [
            'index', 'store', 'destroy'
        ]
    ]);

    Route::get('tags', 'TagController@index');


    Route::resource('forms', 'FormController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    Route::resource('artist', 'ArtistController', [
        'except' => [
            'create', 'edit'
        ]
    ]);

    Route::get('artists', 'ArtistController@filter');

    Route::post('song', 'SongController@store');
    Route::get('songs', 'SongController@index');

    Route::get('contracts', 'SongController@index');
    Route::get('contract', 'SongController@show');
    Route::post('contract', 'ContractController@store');

});
