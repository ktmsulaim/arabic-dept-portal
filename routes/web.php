<?php

use Illuminate\Support\Facades\Route;

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


Auth::routes(['register' => false]);

Route::get('/test', function () {
    print_r(\App\Batch::find(1)->students()->count());
});

Route::get('/{any}', 'HomeController@index')->where('any', '.*')->middleware(['auth']);

// Route::get('/home', 'HomeController@index')->name('home');
