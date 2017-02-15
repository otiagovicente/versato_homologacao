<?php

use Illuminate\Http\Request;

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
Route::get('/user', function (Request $request) {
	return $request->user()->load('representative.brands');
})->middleware('auth:api');

Route::group(['middleware' => 'auth:api'], function () {

	//Rotas dedicadas às marcas

	Route::get('/brands', 'BrandsController@api_index');
	Route::get('/brands/{brand}', 'BrandsController@api_show');
	Route::get('/brands/selectlist', 'BrandsController@api_selectList');
	Route::get('/brands/selectlistByRepresentativeId/{id}', 'BrandsController@api_selectListByRepresentativeId');
	Route::get('/brands/list', 'BrandsController@api_list');
	Route::get('/brands/{brand}/products', 'BrandsController@api_products');
	Route::get('/brands/selectlist', 'BrandsController@api_selectList');


	//Rotas dedicadas a clientes

	Route::get('/customers', 'CustomersController@api_index');
	Route::get('/customers/search', 'CustomersController@api_search');
	Route::get('/customers/selectlist', 'CustomersController@api_selectList');
	Route::get('/customers/{customer}', 'CustomersController@api_show');
	Route::get('/customers/{customer}/shops', 'CustomersController@api_getShops');
	Route::get('/customers/{customer}/deliverycenters', 'CustomersController@api_getDeliveryCenters');


	//Rotas dedicadas às lojas
	Route::get('/shops/{shop}', 'ShopsController@api_show');


	//Rotas dedicadas aos centros de entrega

	Route::get('/deliverycenters/selectlist/{id}', 'DeliverycentersController@api_selectList');
	Route::get('/deliverycenters/{deliverycenter}', 'DeliverycentersController@api_show');


	//Rotas dedicada a representante

	Route::get('/representatives/selectlist', 'RepresentativesController@api_selectList');

	Route::get('/representatives', 'RepresentativesController@api_index');
	Route::get('/representatives/search', 'RepresentativesController@api_search');
	Route::get('/representatives/{representative}', 'RepresentativesController@api_show');
	Route::get('/representatives/{representative}/brands', 'RepresentativesController@api_brands');
	Route::get('/representatives/{representative}/regions', 'RepresentativesController@api_regions');
	Route::get('/representatives/{representative}/user', 'RepresentativesController@api_user');


	//Rotas dedicadas à Macro Regiões e Regiões

	Route::get('/macroregions/', 'MacroregionsController@api_index');
	Route::get('/macroregions/selectlist/', 'MacroregionsController@selectList');
	Route::get('/macroregions/geo/{id}', 'MacroregionsController@getMacroregionGeo');
	Route::get('/macroregions/{macroregion}/regions', 'MacroregionsController@api_regions');
	Route::get('/macroregions/{id}', 'MacroregionsController@api_macroregion');

	Route::get('/regions/selectlist', 'RegionsController@api_selectList');
	Route::get('/regions', 'RegionsController@api_index');
	//Route::resource('macroregions','MacroregionsController');
	//Route::resource('regions','RegionsController');


	//Rotas dedicadasa a produtos

	Route::get('/products/sync/{dtSincronizacao}', 'ProductsController@api_sync');

	Route::get('/products/list', 'ProductsController@api_list');
	Route::get('/products/{product}/edit', 'ProductsController@api_edit');
	Route::get('/products/{product}', 'ProductsController@api_show');
	Route::get('/products/list/{brand}', 'ProductsController@api_list');
	Route::get('/products/listPaginate/{brand}', 'ProductsController@api_listPaginate');
	Route::get('/products/search/{brand}', 'ProductsController@api_search');


	//Rotas dedicadas a Linhas

	Route::get('/lines/list', 'LinesController@api_list');
	Route::get('/lines/{line}/products', 'LinesController@api_products');


	//Rotas dedicadas a referencias
	Route::get('/references/list', 'ReferencesController@api_list');

	//Rotas dedicadas a materiais
	Route::get('/materials/list', 'MaterialsController@api_list');
	Route::get('/materials/{material}/products', 'MaterialsController@api_products');

	//Rotas dedicadas a cores
	Route::get('/colors/{color}/products', 'ColorsController@api_products');
	Route::get('/colors/list', 'ColorsController@api_list');
	Route::get('/colors/{brand_id}', 'ColorsController@api_index');

	//Rotas dedicadas a grids
	Route::get('/grids/{grid}', 'GridsController@api_show');
	Route::get('/grids/list', 'GridsController@api_list');
	Route::get('/grids/selectlist/{brand}', 'GridsController@api_selectList');


	//Rotas dedicadas a tags
	Route::get('/tags/list', 'TagsController@api_list');
	Route::get('/tags/selectlist/{brand}', 'TagsController@api_selectList');


	//Rotas dedicadas a usuários
	Route::get('/users', 'UsersController@api_index');
	Route::get('/users/selectlist', 'UsersController@api_selectList');
	Route::get('/users/search', 'UsersController@api_search');
	Route::get('/users/{user}', 'UsersController@api_show');


	Route::get('/orderstatus', 'OrderstatusController@index');

	//Rotas dedicadas a Pedidos
	Route::post('/orders/sendfavorites/{idRep}/{idCustomer}/{lstProducts}', 'OrdersController@api_sendFavoritesMail');

	Route::post('/orders/search', 'OrdersController@api_search');

	Route::get('/orders/getOrdersByBrand/{dtInicio}/{dtFim}', 'OrdersController@api_getOrdersByBrand');
	Route::get('/orders/getOrdersByRepresentative/{dtInicio}/{dtFim}', 'OrdersController@api_getOrdersByRepresentative');
	Route::get('/orders/getOrdersByCustomer/{dtInicio}/{dtFim}', 'OrdersController@api_getOrdersByCustomer');

	Route::get('/orders/list/{idRepresentive}', 'OrdersController@api_listByRepresentive');
	Route::get('/orders/getProductsFromOrder/{id}', 'OrdersController@api_getProducts');
	Route::get('/orders/listOrdersByRepresentative/{id}', 'OrdersController@api_listOrdersByRepresentative');
	Route::resource('orders', 'OrdersController');


});