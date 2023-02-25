<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use App\Http\Controllers\AuthController;

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

// \Illuminate\Routing\RouteRegistrar controller(string $controller)
//  group() Create a route group with shared attributes.
Route::controller(AuthController::class)
    ->prefix('v1')
    ->group(function () {
            Route::post('/login', 'login');
            Route::post('/me', 'me');
        }
    );

/*
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Put Accept --> application/vnd.api+json in Header Request
JsonApiRoute::server('v1')->prefix('v1')->resources(function ($server) {
    $server->resource('posts', JsonApiController::class)
            //->readOnly()
            ->only('index', 'show', 'store')
            ->relationships(function ($relation){
            // This adds the following routes
            // GET /api/v1/posts/<ID>/<RELATION_NAME>
            // GET /api/v1/posts/<ID>/relationships/<RELATION_NAME>
            $relation->hasOne('author')->readOnly();
            $relation->hasMany('comments')->readOnly();
            $relation->hasOne('tags')->readOnly();
    });
    $server->resource('jobs', JsonApiController::class)
            ->only('index', 'show', 'store', 'update')
            ->relationships(function ($relation){
            $relation->hasMany('job-locations');
    });
    $server->resource('lands', JsonApiController::class)
    ->only('index', 'show', 'store', 'update');

});

