<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'timetable', 'namespace' => 'Timetable\Http\Controllers',
			  'middleware' => ['web']], function() {

        // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

	Route::get('/', 'HomeController@index');
	Route::get('/demo', function() {
		return view('demo');
	});

	Route::group(['middleware' => ['auth.timetable']], function() {
		Route::get('/events', 'EventController@index');
		Route::get('/events/create', 'EventController@create');
		Route::get('/events/{event}', 'EventController@show');
		Route::get('/events/{event}/edit', 'EventController@edit');
		Route::get('/events/{event}/run', 'EventController@run');
		Route::delete('/events/{event}', 'EventController@destroy');
		Route::post('/events', 'EventController@store');
		Route::put('/events/update/{event}', 'EventController@update');

		Route::get('/events/{event}/items/create', 'ItemController@create');
		Route::post('/events/{event}/items', 'ItemController@store');

		Route::post('/slots/{slot}/update', 'SlotController@update');
		Route::post('/events/{event}/slot', 'SlotController@store');
		Route::delete('/slots/{slot}', 'SlotController@delete');
	});
});