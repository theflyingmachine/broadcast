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

Route::get('/', 'PagesController@index');
Route::get('/index', 'PagesController@index');
Route::post('/', 'PagesController@index');
Route::post('/index', 'PagesController@index');


Route::get('/about', 'PagesController@about');
Route::get('/newbroadcast', 'PagesController@newbroadcast');
Route::get('/logout', 'PagesController@logout');
Route::post('/login', 'PagesController@login');
Route::get('/login', 'PagesController@login');


Route::get('/dataapi', 'BroadcastController@dataapi');
Route::post('/broadcaststaging', 'BroadcastController@broadcaststaging');
Route::post('/broadcast', 'BroadcastController@broadcast');
Route::get('/broadcast', 'BroadcastController@broadcast');
Route::get('/testdb', 'BroadcastController@testdb');


Route::get('/viewresponse/{b_id}', 'ResponseController@showresponse');
Route::get('/response/{token}', 'ResponseController@checktoken');
Route::get('/response/{token}/{qresponse}', 'ResponseController@checktokenqresponse');
Route::post('/response', 'ResponseController@submitresponse');
Route::get('/response', 'ResponseController@invalid');
Route::post('/submitresponse', 'ResponseController@submitresponse');



//redirect all invalid route to 404
//Route::any('{all}', 'ResponseController@invalid')->where('all', '.*');