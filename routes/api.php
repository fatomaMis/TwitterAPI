<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function() {
	Route::post('tweet', 'TweetController@store');
	Route::get('tweet/{id}', 'TweetController@show');
	Route::delete('tweet/{id}', 'TweetController@destroy');
});

Route::group(['middleware' => 'auth:api'], function() {
Route::post('users/{id}/action', 'API\UserController@action');
});

Route::get('getTweets','API\UserController@getTweets');
