<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        Route::group(['namespace' => 'Api\Auth'], function () {
            Route::post('login','UserController@userLogin');		
            Route::post('register','UserController@userSignUp');
            
        });

        Route::group(['namespace' => 'Api\Auth'], function () {
            //Route::group(['middleware' => ['auth:api']], function () {
                Route::post('upload-videos','VideosController@uploadVideo');
                Route::post('get-videos-list','VideosController@getVideosList');
                Route::post('download-videos','VideosController@downloadVideo');
                Route::get('videos-count','VideosController@getVideoCount');
            //});
            
        });

        // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        //     return $request->user();
        // });

        // If API not found
        Route::fallback(function(){
            return response()->routeNotFound();
        });
