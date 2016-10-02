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

//// Authentication routes...
//Route::get('/login', 'Auth\AuthController@showLoginForm');
//Route::post('/login', 'Auth\AuthController@login');
//Route::get('/logout', 'Auth\AuthController@logout');

Auth::routes();


Route::group(['middleware' => 'auth'], function () {

    Route::resource('macroregions','MacroregionsController',['parameters' => 'singular']);
	Route::post('/macroregions/update','MacroregionsController@update');
	
	Route::resource('regions','RegionsController',['parameters' => 'singular']);
    Route::resource('customers','CustomersController',['parameters' => 'singular']);
    Route::resource('representatives','RepresentativesController',['parameters' => 'singular']);

    Route::get('/','PagesController@productsDashboard');
    Route::get('/help', 'PagesController@help');
    Route::get('/productsdashboard', 'PagesController@productsDashboard');

    Route::get('/profile','UsersController@profile');
    Route::get('/users/passport','UsersController@passport');
    Route::post('/users/photo', 'UsersController@addPhoto');
    Route::post('/users/changepassword', 'UsersController@changePassword');
    Route::resource('users','UsersController',['parameters' => 'singular']);

	//Route::get('/home', 'HomeController@index');

    Route::get('/brands/select', 'BrandsController@select');
    Route::get('/brands/{brand}/setselected', 'BrandsController@setSelected');
    Route::post('/brands/{brand}/photo', 'BrandsController@addPhoto');
	Route::resource('brands', 'BrandsController',['parameters' => 'singular']);


	Route::post('/lines/search','LinesController@search');
	Route::post('/lines/line/{code}','LinesController@getLineByCode');
	Route::post('/lines/store','LinesController@store');
	Route::post('/lines/update','LinesController@update');
	Route::resource('/lines', 'LinesController', [
			'parameters' => 'singular'
		]);
	
	Route::post('/materials/search', 'MaterialsController@search');
	Route::resource('/materials', 'MaterialsController', [
			'parameters' => 'singular'
		]);
	Route::post('/materials/photo', 'MaterialsController@addPhoto');


	Route::post('/references/search', 'ReferencesController@search');
	Route::resource('/references', 'ReferencesController', [
			'parameters' => 'singular'
		]);

	Route::resource('/products', 'ProductsController', [
			'parameters' => 'singular'
		]);
	Route::post('/products/photo', 'ProductsController@addPhoto');

	Route::post('/colors/search', 'ColorsController@search');
	Route::resource('/colors', 'ColorsController', [
			'parameters' => 'singular'
		]);

    Route::resource('/representatives', 'RepresentativesController',[
        'parameters' => 'singular'
    ]);


});
