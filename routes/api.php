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

/*
 * Route variables validate in RouteServiceProvider
 */
Route::group([
    'namespace' => 'Api\V1',
    'prefix' => 'v1'
], function () {
    Route::group([
        'prefix' => 'document',
    ], function () {
        Route::post('/', [
            'name' => 'api.v1.document.create',
            'uses' => 'DocumentController@create',
        ]);

        Route::get('/{uuid}', [
            'name' => 'api.v1.document.get',
            'uses' => 'DocumentController@get'
        ]);

        Route::patch('/{uuid}', [
            'name' => 'api.v1.document.edit',
            'uses' => 'DocumentController@edit'
        ]);

        Route::post('/{uuid}/publish', [
            'name' => 'api.v1.document.publish',
            'uses' => 'DocumentController@publish'
        ]);

        Route::get('/', [
            'name' => 'api.v1.document.get.list',
            'uses' => 'DocumentController@getList'
        ]);
    });
});
