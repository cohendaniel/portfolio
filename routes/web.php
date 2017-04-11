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

Route::group(['namespace' => 'App\Http\Controllers'], function() {
	// Home

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



	// Small Projects

	Route::get('projects', function() {
		return view('projects.index');
	});
	Route::get('/projects/puzzle', function() {
		return view('projects.puzzle');
	});
	Route::post('projects/puzzle/move', 'ProjectsController@move');
	Route::post('projects/puzzle/solve', 'ProjectsController@solve');

	Route::get('projects/senate', 'ProjectsController@senate');
	Route::get('projects/senatefriends', 'ProjectsController@senateFriends');
	Route::get('projects/senate/update', function() {
		require_once(resource_path('assets/scripts/senate.php'));
	});


	// Beer Cheese Pairing

	Route::get('beercheese', 'BeerCheeseController@index');
	Route::get('beercheese/update', 'BeerCheeseController@update');
	Route::get('beercheese/admin', 'BeerCheeseController@admin');
	Route::get('beercheese/{pair}', 'BeerCheeseController@show');

	// Blog

	Route::get('blog/admin', 'BlogController@admin');
	Route::get('blog/{post}', 'BlogController@show');
	Route::post('blog', 'BlogController@create');

	// Admin

	Auth::routes();
	Route::get('/admin', 'AdminController@index');

});

// Timetable

// Route::group(['prefix' => 'project1', 'namespace' => 'App\Project1\Controllers'], function()
// {
//     Route::get('/', 'HomeController@index');

//     Route::get('posts', 'PostsController@index']);
// });