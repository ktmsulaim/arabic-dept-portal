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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:api']], function () {
    Route::get('/batches/{batch}/students', 'BatchController@getStudents');
    Route::get('/students/{student}/jobs', 'JobController@getByStudent');
    Route::get('/students/{student}/photos', 'PhotoController@getByStudent');

    Route::post('/photos/{photo}/makeProfile', 'PhotoController@makeProfile');
    Route::post('/students/search/{q}', 'StudentController@search');


    Route::get('/home/counts', 'DashboardController@counts');
    Route::get('/home/counts/batches', 'DashboardController@batchCounts');

    Route::apiResources([
        'users' => 'UserController',
        'batches' => 'BatchController',
        'students' => 'StudentController',
        'photos' => 'PhotoController',
        'jobs' => 'JobController'
    ]);
});
