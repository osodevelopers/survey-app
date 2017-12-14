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

Route::middleware('auth:api')->get('survey/list','SurveyController@list');
Route::middleware('auth:api')->get('survey/edit/{id}','SurveyController@edit');
Route::middleware('auth:api')->post('survey/update/{id}','SurveyController@update');
Route::middleware('auth:api')->post('survey/create','SurveyController@store');
Route::middleware('auth:api')->delete('survey/delete/{id}','SurveyController@destroy');