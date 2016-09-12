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

Route::get('/api/products/list', 'ProductsController@api_list');
Route::get('/api/brands/list', 'BrandsController@api_list');
Route::get('/api/lines/list', 'LinesController@api_list');
Route::get('/api/references/list', 'ReferencesController@api_list');
Route::get('/api/materials/list', 'MaterialsController@api_list');
Route::get('/api/colors/list', 'ColorsController@api_list');
Route::get('/api/grids/list', 'GridsController@api_list');
Route::get('/api/tags/list', 'TagsController@api_list');
Route::get('/api/grids/selectlist', 'GridsController@api_selectList');
Route::get('/api/tags/selectlist', 'TagsController@api_selectList');
