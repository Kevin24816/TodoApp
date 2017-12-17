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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'appController@index');

//Route::post('/users', 'appController@createUser');
//
//Route::post('/auth', 'appController@authenticate');
//
//Route::delete('/auth', 'appController@logout');
//
//Route::post('/notes', 'appController@createNote');
//
//Route::get('/notes/:id', 'retrieveNote');
//
//Route::put('notes/:id', 'appController@editNote');
//
//Route::delete('notes/:id', 'appController@deleteNote');

