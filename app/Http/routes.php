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
use App\bbStock;

Route::get('/', 'mainController@index');

Route::get('inteosdb', 'inteosdbController@index');
Route::get('inteosdb/create', 'inteosdbController@create');
//Route::get('inteosdb/{id}', 'inteosdbController@show');
Route::post('inteosdb', 'inteosdbController@create');
Route::post('inteosdb/create', 'bbstockController@create');

Route::get('bbstock', 'bbstockController@index');
Route::get('bbstock/create', 'bbstockController@create');
//Route::get('bbstock/remove', 'bbstockController@remove');
Route::get('bbstock/{id}', 'bbstockController@show');
Route::get('bbstock/{id}/edit', 'bbstockController@edit');
Route::post('bbstock', 'bbstockController@create');
Route::post('bbstock/create', 'bbstockController@create');
Route::patch('bbstock/{id}', 'bbstockController@update');
Route::get('bbstock/{id}/delete', 'bbstockController@delete');


//Route::resource('bbstock', 'bbstockController');

Route::get('removebb', 'removebbController@index');
Route::get('removebb/destroy', 'removebbController@destroy');
Route::post('removebb/destroy', 'removebbController@destroy');
Route::get('removebb/destroybb', 'removebbController@destroybb');
Route::post('removebb/destroybb', 'removebbController@destroybb');

Route::get('search', 'searchController@index');
Route::post('search', 'searchController@search');

Route::get('search2', 'searchController@index2');
Route::post('search2', 'searchController@search2');

Route::get('export', 'exportController@create');

//Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::get('map', 'mapController@index');
Route::get('map/{id}', 'mapController@showbygroup');
Route::get('table', 'mapController@table');

//Status
Route::get('status', 'statusController@index');
Route::get('status/find', 'statusController@find');
Route::post('find_by_status', 'statusController@find_by_status');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
