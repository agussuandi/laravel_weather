<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    if (Auth::user())
    {
    	return redirect('/home');
    }
    else
    {
    	return view('auth.login');
    }
});

#AUTH
Route::post('/login', 'Auth\AuthController@login');
Route::post('/logout', 'Auth\AuthController@logout');

#HOME
Route::get('/home', 'Home\HomeController@index');
Route::get('/home/table', 'Home\HomeController@table');
Route::post('/handleWeather', 'Home\HomeController@handleWeather');
Route::post('/json/currentWeather', 'Home\HomeController@currentWeather');
