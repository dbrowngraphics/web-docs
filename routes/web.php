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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::post('/', function () {
//     return view('welcome');
// });

Route::resource('/', 'NodeController');
Route::resource('nodes', 'NodeController');
Route::resource('category', 'CategoryController');

Route::post('getNode', ['as' => 'getNode', 'uses' => 'NodeController@nodeFilter']);
Route::post('saveNode', ['as' => 'saveNode', 'uses' => 'FormController@store']);
Route::post('/syncNode', ['as' => 'syncNode', 'uses' => 'FormController@sync']);

Route::resource('nodes.forms', 'FormController');
Route::resource('nodes.links', 'LinkController');
Route::resource('nodes.tools', 'ToolController');

