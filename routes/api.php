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
    return $request->user();
})->middleware('auth:api');

Route::get('/brands/selectlist', 'BrandsController@api_selectList');
Route::get('/brands/selectlistByRepresentativeId/{id}', 'BrandsController@api_selectListByRepresentativeId');

Route::get('/grids/selectlist/{brand}', 'GridsController@api_selectList');
Route::get('/tags/selectlist/{brand}', 'TagsController@api_selectList');
Route::get('/users/selectlist', 'UsersController@api_selectList');
Route::get('/regions/selectlist', 'RegionsController@api_selectList');
Route::get('/representatives/selectlist', 'RepresentativesController@api_selectList');
Route::get('/deliverycenters/selectlist/{id}', 'DeliverycentersController@api_selectList');

Route::get('/customers', 'CustomersController@api_index');
Route::get('/customers/selectlist', 'CustomersController@api_selectList');
Route::get('/customers/{customer}', 'CustomersController@api_show');
Route::get('/customers/{customer}/shops', 'CustomersController@api_listShops');

Route::get('/representatives/{representative}','RepresentativesController@api_show');
Route::get('/representatives','RepresentativesController@api_index');

Route::get('/products/list/{brand}', 'ProductsController@api_list');
Route::get('/products/listPaginate/{brand}', 'ProductsController@api_listPaginate');


Route::get('/macroregions/selectlist/', 'MacroregionsController@selectList');
Route::get('/macroregions/geo/{id}', 'MacroregionsController@getMacroregionGeo');

Route::get('/products/sync/{dtSincronizacao}', 'ProductsController@api_sync');
Route::get('/products/list', 'ProductsController@api_list');
Route::get('/products/{product}/edit', 'ProductsController@api_edit');
Route::get('/products/{product}', 'ProductsController@api_show');
Route::get('/products');

Route::get('/brands/list', 'BrandsController@api_list');
Route::get('/lines/list', 'LinesController@api_list');
Route::get('/references/list', 'ReferencesController@api_list');
Route::get('/materials/list', 'MaterialsController@api_list');
Route::get('/colors/{brand_id}', 'ColorsController@api_index');
Route::get('/colors/list', 'ColorsController@api_list');
Route::get('/grids/list', 'GridsController@api_list');
Route::get('/tags/list', 'TagsController@api_list');
Route::get('/users/{user}', 'UsersController@api_show');
Route::get('/users', 'UsersController@api_index');

Route::get('/orders/list/{idRepresentive}', 'OrdersController@api_listByRepresentive');
Route::resource('orders','OrdersController',['parameters' => 'singular']);


