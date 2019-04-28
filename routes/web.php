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

/*
Route::get('/', function () {
    return view('welcome');
});
*/



Route::get('/', 'PagesController@index');
Route::get('/countries', 'PagesController@countries');
Route::get('/countries/{code}', 'PagesController@countries');
Route::get('/locations', 'PagesController@locations');
Route::get('/locations/{locationid}', 'PagesController@locations');
Route::get('/locations/{locationid}/{floors}', 'PagesController@locations');
Route::get('/locations/{locationid}/{floors}/{floorid}', 'PagesController@locations');




