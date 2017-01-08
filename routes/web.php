<?php

use App\Mail\NewOrderMail;
use App\Order;
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

Route::get('/representatives/qrcode', 'RepresentativesController@createTokenQRCode');
Route::get('/enviamail/{id}','OrdersController@sendNewOrderMail');
Route::get('/orders/getOrdersByCustomer/{dtInicio}/{dtFim}', 'OrdersController@api_getOrdersByCustomer');

Route::get('/resizeimage', function(){

	$file = "https://s3-sa-east-1.amazonaws.com/sistema-versato/products/96ce32aeac4385131c0a4bab7ba0b9ed.jpeg";
//	$file = "http://kraken-php.com/build/img/index/logo-php-adbac78231.png";
	$img = Image::make(file_get_contents($file));

	$img->resize(500, null, function ($constraint) {
		$constraint->aspectRatio();
	});
	return $img->response();
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('orders/reportByCustomer','OrdersController@reportByCustomer');
	Route::resource('orders','OrdersController',['parameters' => 'singular']);
    Route::resource('deliverycenters','DeliverycentersController',['parameters' => 'singular']);
	Route::resource('shops','ShopsController',['parameters' => 'singular']);
	
	Route::post('/shops/photo', 'ShopsController@addPhoto');
    
	Route::resource('macroregions','MacroregionsController',['parameters' => 'singular']);
	Route::resource('regions','RegionsController',['parameters' => 'singular']);
	Route::resource('customers','CustomersController',['parameters' => 'singular']);
	Route::post('/customers/photo', 'CustomersController@addPhoto');


    Route::get('/representatives/{representative}/grantaccess','RepresentativesController@showGrantAccess');
    Route::post('/representatives/{representative}/grantaccess', 'RepresentativesController@grantAccess');
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
    Route::post('/brands/photo', 'BrandsController@addPhoto');
    Route::post('/brands/logo', 'BrandsController@addLogo');
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
    Route::get('/products/search/{search}', 'ProductsController@search');
	Route::post('/products/photo', 'ProductsController@addPhoto');


    Route::post('/colors/search', 'ColorsController@search');
	Route::resource('/colors', 'ColorsController', [
			'parameters' => 'singular'
		]);

    Route::resource('/representatives', 'RepresentativesController',[
        'parameters' => 'singular'
    ]);

    Route::resource('/grids', 'GridsController',[
        'parameters' => 'singular'
    ]);

    Route::resource('charts','ChartsController',['parameters' => 'singular']);



	//Rotas do Carrinho de Compras
	Route::post('/shopping-cart/add-product', 'ShoppingCartController@addProduct');
	Route::get('/shopping-cart/get-products', 'ShoppingCartController@getProducts');
	Route::get('/shopping-cart/get-order', 'ShoppingCartController@getOrder');
	Route::get('/shopping-cart/delete-product/{product}', 'ShoppingCartController@deleteProduct');
	Route::post('/shopping-cart/set-customer/{customer}', 'ShoppingCartController@setCustomer');
	Route::get('/shopping-cart/get-customer', 'ShoppingCartController@getCustomer');
	Route::get('/shopping-cart/get-comment','ShoppingCartController@getComment');
	Route::post('/shopping-cart/set-comment','ShoppingCartController@setComment');

	Route::post('/shopping-cart/set-customer-discount', 'ShoppingCartController@setCustomerDiscount');
	Route::post('/shopping-cart/set-representative-discount', 'ShoppingCartController@setRepresentativeDiscount');
	Route::post('/shopping-cart/set-product-amount', 'ShoppingCartController@setProductAmount');
	Route::post('/shopping-cart/set-product-customer-discount', 'ShoppingCartController@setProductCustomerDiscount');
	Route::post('/shopping-cart/set-product-representative-discount', 'ShoppingCartController@setProductRepresentativeDiscount');
	Route::post('/shopping-cart/set-representative/{representative}', 'ShoppingCartController@setRepresentative');
	Route::post('/shopping-cart/get-representative', 'ShoppingCartController@getRepresentative');

	Route::get('/shopping-cart/load-order/{id}','ShoppingCartController@loadOrder');
	Route::get('/shopping-cart/order/{order_id}','ShoppingCartController@loadOrder');


	Route::post('/shopping-cart/set-status','ShoppingCartController@setStatus');
	Route::get('/shopping-cart/get-status','ShoppingCartController@getStatus');
	Route::post('/shopping-cart/save','ShoppingCartController@save');
	Route::post('/shopping-cart/stop-shopping','ShoppingCartController@stopShopping');

	Route::resource('reports','ReportsController',['parameters' => 'singular']);
});
