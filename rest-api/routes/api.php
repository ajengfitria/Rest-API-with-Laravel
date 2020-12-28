<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('stuff','StuffController@get_all_stuff');

Route::post('stuff/add','StuffController@insert_data_stuff');

Route::put('stuff/update/{kode_barang}','StuffController@update_data_stuff');

Route::delete('stuff/delete/{kode_barang}','StuffController@delete_data_stuff');