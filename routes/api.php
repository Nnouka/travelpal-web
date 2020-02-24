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

Route::get('/test', function () {
    $a = [1, 2, 3, 4, 5];
    return sizeof($a);
});
//  public client routes

Route::prefix('public/client')->group(function () {

    Route::post('register', [
        'uses' => 'OAuthClientController@register',
        'as' => 'register.client'
    ]);

});

// protected client routes

Route::prefix('protected/client')->middleware('client.auth')->group(function () {

    Route::get('/test', function () {
        $a = [1, 2, 3, 4, 5];
        return "test is working";
    });

    Route::get('/details', [
        'uses' => 'OAuthClientController@getClientDetails',
        'as' => 'client.details'
        ]);
    Route::post('web_server_redirect_uri', [
        'uses' => 'OAuthClientController@setWebServerRedirectUri',
        'as' => 'client.redirect_uri'
    ]);
    Route::post('app_key', [
        'uses' => 'OAuthClientController@generateAppKey',
        'as' => 'client.appkey'
    ]);
    Route::post('access_token_validity', [
        'uses' => 'OAuthClientController@setAccessTokenValidity',
        'as' => 'client.accessTokenValidity'
    ]);
    Route::post('refresh_token_validity', [
        'uses' => 'OAuthClientController@setRefreshTokenValidity',
        'as' => 'client.refreshTokenValidity'
    ]);
    Route::post('/details/update', [
        'uses' => 'OAuthClientController@updateClientDetails',
        'as' => 'client.update'
    ]);
});

Route::prefix('protected/user')->middleware('client.auth')->group(function () {

    Route::post('register', [
        'uses' => 'UserController@register',
        'as' => 'user.register'
    ]);

});

Route::prefix('protected/token')->middleware('client.auth')->group(function () {

    Route::get('test', [
        'uses' => 'JwtController@test',
        'as' => 'jwt.test'
    ]);

});

Route::get('token/test', [
    'uses' => 'JwtController@test',
    'as' => 'jwt.test'
]);
