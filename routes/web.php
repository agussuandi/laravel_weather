<?php

use Illuminate\Support\Facades\Route;

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
