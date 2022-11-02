<?php

use Illuminate\Support\Facades\Route;

Route::post('/{app}/{path}', 'App\Http\Controllers\EndPointController@postRequest');
Route::get('/{app}/{path}', 'App\Http\Controllers\EndPointController@getRequest');
