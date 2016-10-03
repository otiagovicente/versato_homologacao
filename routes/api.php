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
Route::get('/grids/selectlist/{brand}', 'GridsController@api_selectList');
Route::get('/tags/selectlist/{brand}', 'TagsController@api_selectList');
Route::get('/users/selectlist', 'UsersController@api_selectList');
Route::get('/regions/selectlist/{brand}', 'RegionsController@api_selectList');



Route::get('/representatives/{representative}','RepresentativesController@api_show');
Route::get('/representatives','RepresentativesController@api_index');


Route::get('/products/list/{brand}', 'ProductsController@api_list');
=======
Route::get('/macroregions/selectlist/{brand}', 'MacroregionsController@selectList');
Route::get('/macroregions/geo/{id}', 'MacroregionsController@getMacroregionGeo');



Route::get('/products/list', 'ProductsController@api_list');
>>>>>>> origin/master
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

