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

Route::get('/', function () {
    return view('home');
});

Route::get('/cs', function() {
	return view('cs');
});

Route::get('/about', function() {
	return view('about');
});

Route::get('/resume', function() {
	return view('resume');
});

Route::get('/projects', function() {
	return view('projects');
});


Route::get('beercheese', 'BeerCheeseController@index');
Route::get('beercheese/update', 'BeerCheeseController@update');


Route::get('beercheese/admin', 'BeerCheeseController@admin');
Route::get('beercheese/{pair}', 'BeerCheeseController@show');