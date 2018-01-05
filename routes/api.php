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
Route::group(['middleware'=>['auth:api']], function(){
	Route::post('survey/take','SurveyController@take');
	Route::get('survey/list','SurveyController@list');
	Route::get('survey/available','SurveyController@available');
	Route::get('survey/edit/{id}','SurveyController@edit');
	Route::post('survey/update/{id}','SurveyController@update');
	Route::post('survey/create','SurveyController@store');
	Route::delete('survey/delete/{id}','SurveyController@destroy');
	Route::get('survey/result/{id}','SurveyController@getResult');
	Route::get('survey/{id}','SurveyController@getSurvey');
	Route::get('survey/questions/{id}','SurveyController@getQuestions');
	Route::post('question/create', 'QuestionController@store');
	Route::post('question/update/{id}', 'QuestionController@update');
	Route::delete('question/delete/{id}', 'QuestionController@delete');
});