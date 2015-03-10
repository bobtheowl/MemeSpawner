<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Resource Controllers

Route::resource('meme', 'MemeResource');
Route::get('meme/search', ['uses' => 'MemeResource@search']);
Route::resource('tag', 'TagResource');
Route::resource('generated', 'GeneratedMemeResource');
Route::get('generated/view/{id}', ['uses' => 'GeneratedMemeResource@display']);
Route::get('generated/delete-old/{minutes}', ['uses' => 'GeneratedMemeResource@destroyOldMemes']);

// Pages

Route::get('/', ['uses' => 'PageController@generator']);
Route::get('view', ['uses' => 'PageController@viewer']);
Route::get('manage', ['uses' => 'PageController@manage']);
