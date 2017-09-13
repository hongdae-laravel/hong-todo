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

Route::get('/', 'TaskController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->prefix('tasks')->group( function () {
    Route::get('/', 'TaskController@index')->name('tasks.index');
    Route::post('/', 'TaskController@store')->name('tasks.store');
    Route::get('/{task}', 'TaskController@show')->name('tasks.task.show');
    Route::delete('/{task}', 'TaskController@destroy')->name('tasks.task.delete');
    Route::put('/{task}', 'TaskController@update')->name('tasks.task.update');
});
// #인증 관련 tasks로 리다이렉트