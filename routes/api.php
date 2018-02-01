<?php

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

Route::get('api/base_station/location', 'BaseStation\BaseStationController@locationByBaseStation');
Route::post('api/base_station/location', 'BaseStation\BaseStationController@locationByBaseStation');
Route::get('api/base_stations/location', 'BaseStation\BaseStationController@locationByBaseStations');
Route::post('api/base_stations/location', 'BaseStation\BaseStationController@locationByBaseStations');

Route::get('api/locations', 'BaseStation\BaseStationController@locations');
Route::post('api/locations', 'BaseStation\BaseStationController@locations');