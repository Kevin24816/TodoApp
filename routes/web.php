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

use App\Note;
use App\User;

// USERS
Route::post('/users', 'UserController@signup');
Route::post('/auth', 'UserController@login');
Route::delete('/auth', 'UserController@logout');
Route::delete('/users', 'UserController@destroy');

// NOTES
Route::post('/notes', 'NotesController@store');
Route::get('/notes', 'NotesController@retrieveNotes');
Route::get('/notes/{id}', 'NotesController@getSingleNote');
Route::put('/notes/{id}', 'NotesController@edit');
Route::delete('/notes/{id}', 'NotesController@destroy');

Auth::routes();